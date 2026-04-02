<?php

function db_bind_params($statement, $types, $values) {
    if ($types === '') {
        return;
    }

    $bindValues = [$types];
    foreach ($values as $index => $value) {
        $bindValues[] = &$values[$index];
    }

    if (!call_user_func_array([$statement, 'bind_param'], $bindValues)) {
        error_log('db_connect bind_param failed: ' . $statement->error);
        die('Database operation failed.');
    }
}

function db_normalize_values($params, $values) {
    $normalized = [];

    foreach ($values as $index => $value) {
        $type = $params[$index];

        if ($type === 'i') {
            if ($value === null || $value === '') {
                $normalized[$index] = null;
                continue;
            }

            if (!is_numeric($value)) {
                error_log('db_connect invalid integer parameter at index ' . $index);
                die('Database operation failed.');
            }

            $normalized[$index] = intval($value);
            continue;
        }

        if ($type === 'd') {
            if ($value === null || $value === '') {
                $normalized[$index] = null;
                continue;
            }

            if (!is_numeric($value)) {
                error_log('db_connect invalid double parameter at index ' . $index);
                die('Database operation failed.');
            }

            $normalized[$index] = (float) $value;
            continue;
        }

        if ($type === 's') {
            $normalized[$index] = ($value === null) ? null : (string) $value;
            continue;
        }

        error_log('db_connect unsupported parameter type: ' . $type);
        die('Database operation failed.');
    }

    return $normalized;
}

function db_connect($query, $params, $values, $type = 'select') {
    if (!is_array($params) || !is_array($values) || count($params) !== count($values)) {
        error_log('db_connect parameter/value count mismatch');
        die('Database operation failed.');
    }

    $allowedTypes = ['select', 'insert', 'update', 'delete'];
    if (!in_array($type, $allowedTypes, true)) {
        error_log('db_connect unsupported query type: ' . $type);
        die('Database operation failed.');
    }

    $placeholderCount = substr_count($query, '?');
    if ($placeholderCount !== count($params)) {
        error_log('db_connect placeholder count mismatch');
        die('Database operation failed.');
    }

    $conn = mysqli_init();
    if (!$conn) {
        error_log('db_connect failed to initialize mysqli');
        die('Database connection failed.');
    }
	//Hostinger
    //if (!$conn->real_connect('localhost', 'eav_cs', 'cs$#2026', 'eav_cs')) {
    //    error_log('db_connect connection failed: ' . mysqli_connect_error());
    //    die('Database connection failed.');
    //}
	//Laragon local
	if (!$conn->real_connect($_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME'])) {
        error_log('db_connect connection failed: ' . mysqli_connect_error());
        die('Database connection failed.');
    }
    $conn->set_charset('utf8mb4');

    $statement = $conn->prepare($query);
    if (!$statement) {
        error_log('db_connect prepare failed: ' . $conn->error . ' | Query: ' . $query);
        $conn->close();
        die('Database operation failed.');
    }

    $normalizedValues = db_normalize_values($params, array_values($values));
    $typeString = implode('', $params);
    db_bind_params($statement, $typeString, $normalizedValues);

    if (!$statement->execute()) {
        error_log('db_connect execute failed: ' . $statement->error . ' | Query: ' . $query);
        $statement->close();
        $conn->close();
        die('Database operation failed.');
    }

    switch ($type) {
        case 'select':
            $result = $statement->get_result();
            if ($result === false) {
                error_log('db_connect get_result failed: ' . $statement->error);
                $statement->close();
                $conn->close();
                die('Database operation failed.');
            }

            $data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            $statement->close();
            $conn->close();
            return $data;

        case 'insert':
            $lastInsertId = $conn->insert_id;
            $statement->close();
            $conn->close();
            return $lastInsertId;

        case 'update':
            $affectedRows = $statement->affected_rows;
            $statement->close();
            $conn->close();
            return $affectedRows;

        case 'delete':
            $statement->close();
            $conn->close();
            return true;
    }
}

?>

document.addEventListener('DOMContentLoaded', function () {
    if (window.M && typeof window.M.Collapsible === 'function') {
        M.Collapsible.init(document.querySelectorAll('.collapsible'), {});
    }

    if (window.M && typeof window.M.FormSelect === 'function') {
        M.FormSelect.init(document.querySelectorAll('select'));
    }

    if (window.M && typeof window.M.updateTextFields === 'function') {
        M.updateTextFields();
    }

    document.querySelectorAll('.admin-delete-link').forEach(function (link) {
        link.addEventListener('click', function (event) {
            var entityName = link.getAttribute('data-entity-name') || 'this item';
            if (!window.confirm('Delete ' + entityName + '?')) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('.admin-save-button').forEach(function (button) {
        button.addEventListener('click', function () {
            var buttonType = (button.getAttribute('type') || '').toLowerCase();
            if (buttonType === 'submit') {
                return;
            }

            var formId = button.getAttribute('form') || 'admin-entity-form';
            var form = document.getElementById(formId);
            if (!form) {
                return;
            }

            if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
                if (typeof form.reportValidity === 'function') {
                    form.reportValidity();
                }
                return;
            }

            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit();
            } else {
                form.submit();
            }
        });
    });

    initAdminClientEditors();
});

function initAdminClientEditors() {
    var editorStates = {};
    var activeModalCloser = null;

    function getEditorState(fieldName) {
        if (!editorStates[fieldName]) {
            editorStates[fieldName] = {
                fieldName: fieldName,
                editorElement: null,
                contentElement: null,
                hiddenTextarea: null,
                htmlTextarea: null,
                workspace: null,
                savedRange: null
            };
        }
        return editorStates[fieldName];
    }

    function closeActiveModal() {
        if (typeof activeModalCloser === 'function') {
            activeModalCloser();
        }
    }

    function decodeBase64Utf8(base64) {
        try {
            return decodeURIComponent(escape(window.atob(base64)));
        } catch (error) {
            try {
                return window.atob(base64);
            } catch (fallbackError) {
                return '';
            }
        }
    }

    function saveSelection(state) {
        if (!state || !state.contentElement) {
            return;
        }

        var selection = window.getSelection();
        if (!selection || selection.rangeCount === 0) {
            return;
        }

        var range = selection.getRangeAt(0);
        if (state.contentElement.contains(range.commonAncestorContainer)) {
            state.savedRange = range.cloneRange();
        }
    }

    function restoreSelection(state) {
        if (!state || !state.contentElement) {
            return;
        }

        state.contentElement.focus();
        var selection = window.getSelection();
        if (!selection) {
            return;
        }

        selection.removeAllRanges();
        if (state.savedRange) {
            selection.addRange(state.savedRange);
            return;
        }

        var range = document.createRange();
        range.selectNodeContents(state.contentElement);
        range.collapse(false);
        selection.addRange(range);
        state.savedRange = range.cloneRange();
    }

    function syncStateFromVisual(state) {
        if (!state || !state.contentElement || !state.hiddenTextarea) {
            return;
        }

        var html = state.contentElement.innerHTML;
        state.hiddenTextarea.value = html;
        if (state.htmlTextarea && document.activeElement !== state.htmlTextarea) {
            state.htmlTextarea.value = html;
        }
        saveSelection(state);
    }

    function syncStateFromHtml(state) {
        if (!state || !state.htmlTextarea || !state.hiddenTextarea) {
            return;
        }

        var html = state.htmlTextarea.value;
        state.hiddenTextarea.value = html;
        if (state.contentElement) {
            state.contentElement.innerHTML = html;
        }
    }

    function insertHtmlAtCursor(state, html) {
        if (!state || !state.contentElement) {
            return;
        }

        restoreSelection(state);
        var selection = window.getSelection();
        if (!selection || selection.rangeCount === 0) {
            state.contentElement.insertAdjacentHTML('beforeend', html);
            syncStateFromVisual(state);
            return;
        }

        var range = selection.getRangeAt(0);
        range.deleteContents();
        var fragment = range.createContextualFragment(html);
        var lastNode = fragment.lastChild;
        range.insertNode(fragment);

        if (lastNode) {
            range = range.cloneRange();
            range.setStartAfter(lastNode);
            range.collapse(true);
            selection.removeAllRanges();
            selection.addRange(range);
            state.savedRange = range.cloneRange();
        }

        syncStateFromVisual(state);
    }

    function setWorkspaceTab(workspace, targetTab) {
        if (!workspace) {
            return;
        }

        var fieldName = workspace.getAttribute('data-field-name') || '';
        var state = fieldName ? getEditorState(fieldName) : null;

        if (state) {
            if (targetTab === 'html') {
                syncStateFromVisual(state);
                if (state.htmlTextarea) {
                    state.htmlTextarea.value = state.hiddenTextarea ? state.hiddenTextarea.value : '';
                }
            }

            if (targetTab === 'visual') {
                syncStateFromHtml(state);
            }
        }

        workspace.querySelectorAll('.admin-editor-tab').forEach(function (button) {
            button.classList.toggle('is-active', button.getAttribute('data-editor-tab') === targetTab);
        });
        workspace.querySelectorAll('.admin-editor-pane').forEach(function (pane) {
            pane.classList.toggle('is-active', pane.getAttribute('data-editor-pane') === targetTab);
        });
    }

    function openCmsModal(title, buildBody) {
        closeActiveModal();

        var overlay = document.createElement('div');
        overlay.className = 'admin-cms-modal';
        overlay.innerHTML = ''
            + '<div class="admin-cms-modal__backdrop"></div>'
            + '<div class="admin-cms-modal__dialog">'
            + '  <div class="admin-cms-modal__header">'
            + '    <h5>' + title + '</h5>'
            + '    <button type="button" class="admin-cms-modal__close"><i class="material-icons">close</i></button>'
            + '  </div>'
            + '  <div class="admin-cms-modal__body"></div>'
            + '  <div class="admin-cms-modal__footer"></div>'
            + '</div>';

        document.body.appendChild(overlay);

        var body = overlay.querySelector('.admin-cms-modal__body');
        var footer = overlay.querySelector('.admin-cms-modal__footer');
        var closed = false;

        function closeModal() {
            if (closed) {
                return;
            }
            closed = true;
            document.removeEventListener('keydown', handleEscape);
            overlay.remove();
            if (activeModalCloser === closeModal) {
                activeModalCloser = null;
            }
        }

        function handleEscape(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        }

        document.addEventListener('keydown', handleEscape);
        overlay.querySelector('.admin-cms-modal__close').addEventListener('click', closeModal);
        overlay.querySelector('.admin-cms-modal__backdrop').addEventListener('click', closeModal);
        activeModalCloser = closeModal;

        buildBody(body, footer, closeModal);
        return closeModal;
    }

    function openImageBrowser(state) {
        var imageContainer = document.querySelector('.images-browse-list');
        var imageNodes = imageContainer ? Array.prototype.slice.call(imageContainer.querySelectorAll('img[data-src]')) : [];

        openCmsModal('Insert Image', function (body, footer, closeModal) {
            var selectedSrc = '';
            var uploadInputId = 'admin-image-upload-' + Date.now();
            body.classList.add('admin-cms-modal__body--image');
            footer.classList.add('admin-cms-modal__footer--sticky');
            body.innerHTML = ''
                + '<div class="admin-upload-dropzone" data-upload-dropzone>'
                + '  <input type="file" id="' + uploadInputId + '" accept="image/*" hidden>'
                + '  <div class="admin-upload-dropzone__icon"><i class="material-icons">cloud_upload</i></div>'
                + '  <div class="admin-upload-dropzone__title">Drop an image here or click to upload</div>'
                + '  <div class="admin-upload-dropzone__note">PNG, JPG, GIF, and WebP are supported.</div>'
                + '</div>'
                + '<div class="admin-upload-status" data-upload-status></div>'
                + '<div class="admin-media-grid"></div>'
                + '<div class="admin-modal-preview"><div class="admin-modal-preview__placeholder">Choose or upload an image to preview it here before inserting.</div></div>';

            var grid = body.querySelector('.admin-media-grid');
            var preview = body.querySelector('.admin-modal-preview');
            var dropzone = body.querySelector('[data-upload-dropzone]');
            var fileInput = body.querySelector('#' + uploadInputId);
            var status = body.querySelector('[data-upload-status]');

            function setStatus(message, type) {
                status.textContent = message || '';
                status.className = 'admin-upload-status' + (type ? ' is-' + type : '');
            }

            function syncHiddenImageList(src) {
                var container = imageContainer;
                if (!container) {
                    container = document.createElement('div');
                    container.className = 'images-browse-list';
                    container.style.display = 'none';
                    document.body.appendChild(container);
                    imageContainer = container;
                }

                var existing = Array.prototype.slice.call(container.querySelectorAll('img[data-src]')).find(function (imageNode) {
                    return (imageNode.getAttribute('data-src') || '') === src;
                });
                if (existing) {
                    return;
                }

                var image = document.createElement('img');
                image.setAttribute('data-src', src);
                image.setAttribute('alt', 'Media');
                container.appendChild(image);
                imageNodes.push(image);
            }

            function selectCard(card, src) {
                selectedSrc = src;
                grid.querySelectorAll('.admin-media-thumb').forEach(function (item) {
                    item.classList.remove('is-selected');
                });
                card.classList.add('is-selected');
                preview.innerHTML = '<img src="' + src + '" alt="Selected image">';
                insertButton.disabled = false;
            }

            function addImageCard(src, label, prepend) {
                var card = document.createElement('button');
                card.type = 'button';
                card.className = 'admin-media-thumb';
                card.innerHTML = '<img src="' + src + '" alt="Media preview"><div class="admin-media-thumb__label">' + label + '</div>';
                card.addEventListener('click', function () {
                    selectCard(card, src);
                });

                if (prepend && grid.firstChild) {
                    grid.insertBefore(card, grid.firstChild);
                } else {
                    grid.appendChild(card);
                }

                return card;
            }

            function uploadFile(file) {
                if (!file) {
                    return;
                }

                if (!file.type || file.type.indexOf('image/') !== 0) {
                    setStatus('Please upload a valid image file.', 'error');
                    return;
                }

                setStatus('Uploading image...', 'pending');
                dropzone.classList.add('is-uploading');

                var formData = new FormData();
                formData.append('image', file);

                fetch('media_upload.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin'
                }).then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                }).then(function (result) {
                    dropzone.classList.remove('is-uploading');
                    if (!result.ok || !result.data || !result.data.success || !result.data.url) {
                        setStatus((result.data && result.data.message) ? result.data.message : 'Image upload failed.', 'error');
                        return;
                    }

                    setStatus('Image uploaded successfully.', 'success');
                    syncHiddenImageList(result.data.url);
                    var card = addImageCard(result.data.url, result.data.name || 'New image', true);
                    selectCard(card, result.data.url);
                }).catch(function () {
                    dropzone.classList.remove('is-uploading');
                    setStatus('Image upload failed.', 'error');
                });
            }

            imageNodes.forEach(function (imageNode, index) {
                var src = imageNode.getAttribute('data-src') || '';
                addImageCard(src, 'Image ' + (index + 1), false);
            });

            dropzone.addEventListener('click', function () {
                if (!dropzone.classList.contains('is-uploading')) {
                    fileInput.click();
                }
            });

            fileInput.addEventListener('change', function () {
                if (fileInput.files && fileInput.files[0]) {
                    uploadFile(fileInput.files[0]);
                    fileInput.value = '';
                }
            });

            ['dragenter', 'dragover'].forEach(function (eventName) {
                dropzone.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    dropzone.classList.add('is-dragover');
                });
            });

            ['dragleave', 'dragend'].forEach(function (eventName) {
                dropzone.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    dropzone.classList.remove('is-dragover');
                });
            });

            dropzone.addEventListener('drop', function (event) {
                event.preventDefault();
                dropzone.classList.remove('is-dragover');
                if (event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files[0]) {
                    uploadFile(event.dataTransfer.files[0]);
                }
            });

            var cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.className = 'btn-flat';
            cancelButton.textContent = 'Cancel';
            cancelButton.addEventListener('click', closeModal);

            var insertButton = document.createElement('button');
            insertButton.type = 'button';
            insertButton.className = 'btn brown';
            insertButton.textContent = 'Insert Image';
            insertButton.disabled = true;
            insertButton.addEventListener('click', function () {
                if (!selectedSrc) {
                    return;
                }
                insertHtmlAtCursor(state, '<img src="' + selectedSrc + '" alt="">');
                closeModal();
            });

            footer.appendChild(cancelButton);
            footer.appendChild(insertButton);
        });
    }

    function openTemplateBrowser(state) {
        var templates = Array.prototype.slice.call(document.querySelectorAll('.templates-browse-list li[data-template-html-base64]'));
        if (!templates.length) {
            return;
        }

        openCmsModal('Insert Section', function (body, footer, closeModal) {
            var selectedHtml = '';
            body.innerHTML = '<div class="admin-template-grid"></div><div class="admin-modal-preview"><div class="admin-modal-preview__placeholder">Choose a section to preview its layout before inserting.</div></div>';
            var grid = body.querySelector('.admin-template-grid');
            var preview = body.querySelector('.admin-modal-preview');

            templates.forEach(function (templateNode) {
                var html = decodeBase64Utf8(templateNode.getAttribute('data-template-html-base64') || '');
                var label = templateNode.getAttribute('data-template-label') || 'Section';
                var card = document.createElement('button');
                card.type = 'button';
                card.className = 'admin-template-thumb';
                card.innerHTML = '<div class="admin-template-thumb__preview"><div>' + html + '</div></div><div class="admin-template-thumb__label">' + label + '</div>';
                card.addEventListener('click', function () {
                    selectedHtml = html;
                    grid.querySelectorAll('.admin-template-thumb').forEach(function (item) {
                        item.classList.remove('is-selected');
                    });
                    card.classList.add('is-selected');
                    preview.innerHTML = html;
                    insertButton.disabled = false;
                });
                grid.appendChild(card);
            });

            var cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.className = 'btn-flat';
            cancelButton.textContent = 'Cancel';
            cancelButton.addEventListener('click', closeModal);

            var insertButton = document.createElement('button');
            insertButton.type = 'button';
            insertButton.className = 'btn brown';
            insertButton.textContent = 'Insert Section';
            insertButton.disabled = true;
            insertButton.addEventListener('click', function () {
                if (!selectedHtml) {
                    return;
                }
                insertHtmlAtCursor(state, selectedHtml);
                closeModal();
            });

            footer.appendChild(cancelButton);
            footer.appendChild(insertButton);
        });
    }

    document.querySelectorAll('.admin-editor-workspace').forEach(function (workspace) {
        var fieldName = workspace.getAttribute('data-field-name') || '';
        if (!fieldName) {
            return;
        }

        var state = getEditorState(fieldName);
        state.workspace = workspace;

        workspace.querySelectorAll('.admin-editor-tab').forEach(function (button) {
            button.addEventListener('click', function () {
                setWorkspaceTab(workspace, button.getAttribute('data-editor-tab') || 'visual');
            });
        });
    });

    document.querySelectorAll('.admin-raw-html-editor').forEach(function (textarea) {
        var fieldName = textarea.getAttribute('data-field-name') || '';
        if (!fieldName) {
            return;
        }

        var state = getEditorState(fieldName);
        state.htmlTextarea = textarea;
        textarea.addEventListener('input', function () {
            if (state.hiddenTextarea) {
                state.hiddenTextarea.value = textarea.value;
            }
        });
    });

    document.querySelectorAll('.admin-entity-form .pell').forEach(function (editorElement) {
        if (typeof window.pell === 'undefined') {
            return;
        }

        var fieldName = editorElement.getAttribute('data-field-name') || '';
        if (!fieldName) {
            return;
        }

        var state = getEditorState(fieldName);
        state.editorElement = editorElement;

        var initialInput = editorElement.querySelector('.edit-content');
        var initialHtml = initialInput ? initialInput.value : '';
        var hiddenTextarea = document.createElement('textarea');
        hiddenTextarea.name = fieldName;
        hiddenTextarea.className = 'admin-hidden-html-sync';
        hiddenTextarea.style.display = 'none';
        hiddenTextarea.value = initialHtml;
        editorElement.appendChild(hiddenTextarea);
        state.hiddenTextarea = hiddenTextarea;

        window.pell.init({
            element: editorElement,
            onChange: function (html) {
                if (state.hiddenTextarea) {
                    state.hiddenTextarea.value = html;
                }
                if (state.htmlTextarea && document.activeElement !== state.htmlTextarea) {
                    state.htmlTextarea.value = html;
                }
            },
            actions: [
                'bold', 'italic', 'underline', 'strikethrough', 'heading1', 'heading2',
                'paragraph', 'quote', 'olist', 'ulist', 'code', 'line', 'link',
                {
                    name: 'image',
                    icon: '<i class="material-icons">image</i>',
                    title: 'Insert Image',
                    result: function () {
                        openImageBrowser(state);
                    }
                },
                {
                    name: 'template',
                    icon: '<i class="material-icons">view_quilt</i>',
                    title: 'Insert Section',
                    result: function () {
                        openTemplateBrowser(state);
                    }
                },
                {
                    name: 'html',
                    icon: '<i class="material-icons">code</i>',
                    title: 'Edit HTML',
                    result: function () {
                        if (state.workspace) {
                            setWorkspaceTab(state.workspace, 'html');
                            if (state.htmlTextarea) {
                                state.htmlTextarea.focus();
                            }
                        }
                    }
                }
            ]
        });

        state.contentElement = editorElement.querySelector('.pell-content');
        if (state.contentElement) {
            state.contentElement.innerHTML = initialHtml;
            ['mouseup', 'keyup', 'focus', 'input'].forEach(function (eventName) {
                state.contentElement.addEventListener(eventName, function () {
                    saveSelection(state);
                    syncStateFromVisual(state);
                });
            });
        }

        if (state.htmlTextarea) {
            state.htmlTextarea.value = initialHtml;
        }
    });
}






document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            syncAdminClientEditorsBeforeSubmit(form);
        });
    });
});

function syncAdminClientEditorsBeforeSubmit(form) {
    if (!form) {
        return;
    }

    form.querySelectorAll('.admin-raw-html-editor').forEach(function (textarea) {
        var fieldName = textarea.getAttribute('data-field-name') || '';
        if (!fieldName) {
            return;
        }

        var hiddenTextarea = findHiddenEditorField(form, fieldName);
        if (hiddenTextarea) {
            hiddenTextarea.value = textarea.value;
        }
    });

    form.querySelectorAll('.pell-content input, .pell-content select, .pell-content textarea, .pell-content button').forEach(function (control) {
        control.disabled = true;
        control.removeAttribute('required');
        control.removeAttribute('name');
    });
}

function findHiddenEditorField(form, fieldName) {
    var hiddenFields = form.querySelectorAll('.admin-hidden-html-sync');
    for (var index = 0; index < hiddenFields.length; index += 1) {
        if ((hiddenFields[index].getAttribute('name') || '') === fieldName) {
            return hiddenFields[index];
        }
    }

    return null;
}

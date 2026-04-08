<?php
$pageTitle = 'Dashboard';
$dashboardCurrency = $config['currency_code'] ?? 'USD';
?>
<section class="admin-content">
    <div class="admin-card">
        <div class="card-label">Overview</div>
        <h4 style="margin-top: 0;">Client Workspace</h4>
        <p>This panel is connected to the shared core layer and is ready for project-specific tools to be added later.</p>
    </div>

    <div class="row" style="margin-top: 2px;">
        <div class="col s12 m6 l3">
            <div class="admin-card dashboard-stat-card">
                <div class="card-label">Today&#8217;s Orders</div>
                <h4 id="demo-stat-orders" style="margin: 0;">--</h4>
                <p class="helper-note" style="margin-bottom: 0;">Orders captured today</p>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="admin-card dashboard-stat-card">
                <div class="card-label">Today&#8217;s Revenue</div>
                <h4 id="demo-stat-revenue" style="margin: 0;">--</h4>
                <p class="helper-note" style="margin-bottom: 0;">Estimated demo revenue</p>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="admin-card dashboard-stat-card">
                <div class="card-label">Pending Orders</div>
                <h4 id="demo-stat-pending" style="margin: 0;">--</h4>
                <p class="helper-note" style="margin-bottom: 0;">Needs kitchen attention</p>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="admin-card dashboard-stat-card">
                <div class="card-label">Popular Item</div>
                <h4 id="demo-stat-item" style="margin: 0;">--</h4>
                <p class="helper-note" style="margin-bottom: 0;">Most ordered today</p>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 0;">
        <div class="col s12 l7">
            <div class="admin-card">
                <div class="card-label">Sales Trend</div>
                <h5 style="margin-top: 0;">Revenue Through The Day</h5>
                <div style="height: 320px;">
                    <canvas id="demo-sales-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col s12 l5">
            <div class="admin-card">
                <div class="card-label">Recent Orders</div>
                <h5 style="margin-top: 0;">Latest Activity</h5>
                <div id="demo-recent-orders">
                    <p class="helper-note">Loading demo orders...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module">
const DEMO_MODE = true;
const DASHBOARD_CURRENCY = <?php echo json_encode($dashboardCurrency); ?>;

if (DEMO_MODE) {
  const { getStats, getOrders, getSalesTrend } = await import('../demo/useDemoData.js');

  const formatCurrency = (value) => new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: DASHBOARD_CURRENCY,
    maximumFractionDigits: 0
  }).format(Number(value || 0));

  const stats = getStats();
  const orders = getOrders().slice(0, 5);
  const salesTrend = getSalesTrend();

  const setText = (id, value) => {
    const node = document.getElementById(id);
    if (node) {
      node.textContent = value;
    }
  };

  setText('demo-stat-orders', String(stats.todayOrders ?? '--'));
  setText('demo-stat-revenue', formatCurrency(stats.todayRevenue));
  setText('demo-stat-pending', String(stats.pendingOrders ?? '--'));
  setText('demo-stat-item', String(stats.popularItem || '--'));

  const recentOrders = document.getElementById('demo-recent-orders');
  if (recentOrders) {
    recentOrders.innerHTML = orders.map((order) => {
      const statusClass = String(order.status || '').toLowerCase() === 'pending'
        ? 'amber lighten-4 amber-text text-darken-4'
        : 'green lighten-4 green-text text-darken-4';

      return `
        <div class="dashboard-order-row" style="padding: 14px 0; border-bottom: 1px solid #efe5d8;">
          <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start;">
            <div>
              <strong>${order.id}</strong>
              <div class="helper-note" style="margin-top:6px;">${order.items.join(', ')}</div>
            </div>
            <span class="new badge ${statusClass}" data-badge-caption="">${order.status}</span>
          </div>
          <div style="display:flex;justify-content:space-between;gap:12px;margin-top:10px;color:#6f675c;">
            <span>${formatCurrency(order.total)}</span>
            <span>${order.type} · ${order.time}</span>
          </div>
        </div>
      `;
    }).join('');
  }

  const chartCanvas = document.getElementById('demo-sales-chart');
  if (chartCanvas && window.Chart) {
    new Chart(chartCanvas, {
      type: 'line',
      data: {
        labels: salesTrend.map((point) => point.time),
        datasets: [{
          label: 'Revenue',
          data: salesTrend.map((point) => point.revenue),
          borderColor: '#9a6844',
          backgroundColor: 'rgba(154, 104, 68, 0.14)',
          pointBackgroundColor: '#1f2a2c',
          pointBorderColor: '#1f2a2c',
          borderWidth: 3,
          fill: true,
          tension: 0.35
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              callback: (value) => `${DASHBOARD_CURRENCY} ${value}`
            }
          }
        }
      }
    });
  }
}
</script>

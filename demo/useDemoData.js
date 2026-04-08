import demoData from './demoData.json' with { type: 'json' };

export function getStats() {
  return demoData.stats || {};
}

export function getOrders() {
  return Array.isArray(demoData.orders) ? demoData.orders : [];
}

export function getSalesTrend() {
  return Array.isArray(demoData.salesTrend) ? demoData.salesTrend : [];
}

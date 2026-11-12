/**
 * Reports Page JavaScript
 * Handles charts, report switching, and export functionality
 */

import Chart from 'chart.js/auto';

// Global variables
let currentReport = 'sales';
let selectedExportFormat = 'pdf';
let charts = {};

// Initialize CSRF token - will be set from page
let csrfToken = '';

/**
 * Set CSRF token from page
 */
export function setCsrfToken(token) {
    csrfToken = token;
}

/**
 * Show alert message
 */
export function showAlert(message, type = 'success') {
    const alert = document.getElementById('alertMessage');
    const alertText = document.getElementById('alertText');

    if (alert && alertText) {
        alertText.textContent = message;
        alert.className = `alert-message ${type} show`;

        setTimeout(() => {
            alert.classList.remove('show');
        }, 3000);
        alert.style.display = 'flex';
    }
}

/**
 * Switch between reports
 */
export function switchReport(reportName) {
    // Update tabs
    document.querySelectorAll('.report-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }

    // Hide all reports
    document.querySelectorAll('.report-section').forEach(section => {
        section.classList.remove('active');
    });

    // Show selected report
    const reportSection = document.getElementById(`${reportName}-report`);
    if (reportSection) {
        reportSection.classList.add('active');
    }

    // Save current report
    currentReport = reportName;

    // Update report data
    updateReportData(reportName);
}

/**
 * Apply date filter
 */
export function applyDateFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (startDate && endDate && startDate <= endDate) {
        showAlert(`تم تطبيق الفلتر من ${startDate} إلى ${endDate}`);
        updateReportData(currentReport);
    } else {
        showAlert('الرجاء اختيار فترة زمنية صحيحة', 'error');
    }
}

/**
 * Update report data via AJAX
 */
export function updateReportData(reportName) {
    const startDate = document.getElementById('startDate')?.value;
    const endDate = document.getElementById('endDate')?.value;

    fetch('/reports/data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            report_type: reportName,
            start_date: startDate,
            end_date: endDate
        })
    })
        .then(response => response.json())
        .then(data => {
            switch (reportName) {
                case 'sales':
                    updateSalesReport(data);
                    break;
                case 'profit':
                    updateProfitReport(data);
                    break;
                case 'inventory':
                    updateInventoryReport(data);
                    break;
                case 'debt':
                    updateDebtReport(data);
                    break;
                case 'expiry':
                    updateExpiryReport(data);
                    break;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('حدث خطأ في تحميل البيانات', 'error');
        });
}

/**
 * Destroy charts by IDs
 */
function destroyCharts(chartIds) {
    chartIds.forEach(id => {
        if (charts[id]) {
            charts[id].destroy();
            delete charts[id];
        }
    });
}

/**
 * Update sales report
 */
function updateSalesReport(data) {
    destroyCharts(['monthlySalesChart', 'salesByTypeChart']);

    // Monthly sales chart
    if (data.monthly && data.monthly.length > 0) {
        const monthlySalesCtx = document.getElementById('monthlySalesChart')?.getContext('2d');
        if (monthlySalesCtx) {
            const labels = data.monthly.map(item => `${item.year}-${item.month}`);
            const salesData = data.monthly.map(item => parseFloat(item.total));

            charts.monthlySalesChart = new Chart(monthlySalesCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'المبيعات (ر.س)',
                        data: salesData,
                        borderColor: '#0066ff',
                        backgroundColor: 'rgba(0, 102, 255, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            rtl: true,
                            labels: {
                                font: { family: "'Tajawal', sans-serif" }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return value.toLocaleString('ar-SA') + ' ر.س';
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Sales by type chart
    if (data.byType && data.byType.length > 0) {
        const salesByTypeCtx = document.getElementById('salesByTypeChart')?.getContext('2d');
        if (salesByTypeCtx) {
            const labels = data.byType.map(item => item.sale_type === 'cash' ? 'نقداً' : 'آجل');
            const typeData = data.byType.map(item => parseFloat(item.total));

            charts.salesByTypeChart = new Chart(salesByTypeCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: typeData,
                        backgroundColor: ['#34c759', '#ff9500'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: true,
                            labels: {
                                font: { family: "'Tajawal', sans-serif" }
                            }
                        }
                    }
                }
            });
        }
    }

    // Update tables
    updateSalesTables(data);
}

/**
 * Update sales tables
 */
function updateSalesTables(data) {
    const salesSummaryTable = document.getElementById('salesSummaryTable');
    const topProductsTable = document.getElementById('topProductsTable');

    // Sales summary
    if (salesSummaryTable) {
        if (data.summary && data.summary.length > 0) {
            salesSummaryTable.innerHTML = data.summary.map(row => `
                <tr>
                    <td>${row.date}</td>
                    <td>${row.invoices}</td>
                    <td>${parseFloat(row.cash).toLocaleString('ar-SA', { minimumFractionDigits: 2 })} ر.س</td>
                    <td>${parseFloat(row.credit).toLocaleString('ar-SA', { minimumFractionDigits: 2 })} ر.س</td>
                    <td><strong>${parseFloat(row.total).toLocaleString('ar-SA', { minimumFractionDigits: 2 })} ر.س</strong></td>
                </tr>
            `).join('');
        } else {
            salesSummaryTable.innerHTML = `
                <tr>
                    <td colspan="5" class="empty-state">
                        <i class="fas fa-chart-bar"></i>
                        <p>لا توجد بيانات للعرض</p>
                    </td>
                </tr>
            `;
        }
    }

    // Top products
    if (topProductsTable) {
        if (data.topProducts && data.topProducts.length > 0) {
            const totalRevenue = data.topProducts.reduce((sum, product) => sum + parseFloat(product.revenue), 0);

            topProductsTable.innerHTML = data.topProducts.map((product, index) => {
                const percentage = totalRevenue > 0 ? ((parseFloat(product.revenue) / totalRevenue) * 100).toFixed(1) : 0;
                return `
                    <tr>
                        <td>
                            <span style="display: inline-block; width: 24px; height: 24px; background: #0066ff; color: white; border-radius: 50%; text-align: center; line-height: 24px; margin-left: 8px;">
                                ${index + 1}
                            </span>
                            ${product.name}
                        </td>
                        <td>${parseInt(product.quantity).toLocaleString('ar-SA')}</td>
                        <td>${parseFloat(product.revenue).toLocaleString('ar-SA', { minimumFractionDigits: 2 })} ر.س</td>
                        <td>
                            <div style="background: #f2f2f7; border-radius: 10px; height: 20px; overflow: hidden;">
                                <div style="background: #0066ff; width: ${percentage}%; height: 100%;"></div>
                            </div>
                            <small style="color: #8e8e93;">${percentage}%</small>
                        </td>
                    </tr>
                `;
            }).join('');
        } else {
            topProductsTable.innerHTML = `
                <tr>
                    <td colspan="4" class="empty-state">
                        <i class="fas fa-box"></i>
                        <p>لا توجد بيانات للعرض</p>
                    </td>
                </tr>
            `;
        }
    }
}

/**
 * Update profit report
 */
function updateProfitReport(data) {
    destroyCharts(['monthlyProfitChart', 'profitByCategoryChart']);
    // Implement profit charts similar to sales
}

/**
 * Update inventory report
 */
function updateInventoryReport(data) {
    destroyCharts(['inventoryByCategoryChart', 'inventoryValueChart']);
    // Implement inventory charts
}

/**
 * Update debt report
 */
function updateDebtReport(data) {
    destroyCharts(['debtDistributionChart', 'monthlyDebtChart']);
    // Implement debt charts
}

/**
 * Update expiry report
 */
function updateExpiryReport(data) {
    destroyCharts(['expiryDistributionChart', 'expiredValueChart']);
    // Implement expiry charts
}

/**
 * Open export modal
 */
export function openExportModal() {
    document.querySelectorAll('.export-option').forEach(option => {
        option.classList.remove('selected');
    });
    // Select PDF by default
    const pdfOption = document.querySelector('.export-option');
    if (pdfOption) pdfOption.classList.add('selected');

    const modal = document.getElementById('exportModal');
    if (modal) modal.classList.add('active');
}

/**
 * Close export modal
 */
export function closeExportModal() {
    const modal = document.getElementById('exportModal');
    if (modal) modal.classList.remove('active');
}

/**
 * Select export format
 */
export function selectExportFormat(format) {
    selectedExportFormat = format;

    document.querySelectorAll('.export-option').forEach(option => {
        option.classList.remove('selected');
    });
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('selected');
    }
}

/**
 * Export report
 */
export function exportReport() {
    const startDate = document.getElementById('startDate')?.value;
    const endDate = document.getElementById('endDate')?.value;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/reports/export';
    form.style.display = 'none';

    // CSRF Token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    // Report Type
    const reportInput = document.createElement('input');
    reportInput.type = 'hidden';
    reportInput.name = 'report_type';
    reportInput.value = currentReport;
    form.appendChild(reportInput);

    // Format
    const formatInput = document.createElement('input');
    formatInput.type = 'hidden';
    formatInput.name = 'format';
    formatInput.value = selectedExportFormat;
    form.appendChild(formatInput);

    // Dates
    if (startDate) {
        const startDateInput = document.createElement('input');
        startDateInput.type = 'hidden';
        startDateInput.name = 'start_date';
        startDateInput.value = startDate;
        form.appendChild(startDateInput);
    }

    if (endDate) {
        const endDateInput = document.createElement('input');
        endDateInput.type = 'hidden';
        endDateInput.name = 'end_date';
        endDateInput.value = endDate;
        form.appendChild(endDateInput);
    }

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    closeExportModal();
}

/**
 * Print report
 */
export function printReport(reportType) {
    const reportNames = {
        'sales': 'المبيعات',
        'profit': 'الأرباح',
        'inventory': 'المخزون',
        'debt': 'الديون',
        'expiry': 'الصلاحية'
    };
    const reportName = reportNames[reportType] || '';
    showAlert(`جاري إعداد تقرير ${reportName} للطباعة...`);

    setTimeout(() => {
        window.print();
    }, 1000);
}

/**
 * Toggle sidebar on mobile
 */
export function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

/**
 * Initialize reports page
 */
export function initReportsPage(token) {
    csrfToken = token;

    // Load initial report data
    updateReportData(currentReport);

    // Close sidebar on outside click (mobile)
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');

        if (window.innerWidth <= 768 &&
            sidebar &&
            !sidebar.contains(event.target) &&
            (!mobileMenuBtn || !mobileMenuBtn.contains(event.target)) &&
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
}

// Expose functions to window for onclick handlers
window.switchReport = switchReport;
window.applyDateFilter = applyDateFilter;
window.openExportModal = openExportModal;
window.closeExportModal = closeExportModal;
window.selectExportFormat = selectExportFormat;
window.exportReport = exportReport;
window.printReport = printReport;
window.toggleSidebar = toggleSidebar;
window.initReportsPage = initReportsPage;
window.showAlert = showAlert;

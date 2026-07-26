class DashboardReport {

    constructor() {

        const { jsPDF } = window.jspdf;

        this.pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4'
        });

        this.margin = 15;
        this.pageWidth = this.pdf.internal.pageSize.getWidth();
        this.pageHeight = this.pdf.internal.pageSize.getHeight();
        this.contentWidth = this.pageWidth - (this.margin * 2);

        this.y = 16;

        this.colors = {
            brand: [128, 0, 0],
            border: [224, 224, 224],
            muted: [110, 110, 110],
            text: [35, 35, 35]
        };
    }

    async getChartDataUri(chartId, exportOptions = {}) {

        const chart = await ApexCharts.exec(chartId, 'dataURI', exportOptions);

        if (chart && chart.imgURI) {
            return chart;
        }

        throw new Error('Unable to export chart: ' + chartId);
    }

    header() {

        this.pdf.setFillColor(...this.colors.brand);
        this.pdf.rect(0, 0, this.pageWidth, 24, 'F');

        this.pdf.setFont('helvetica', 'bold');
        this.pdf.setFontSize(16);
        this.pdf.setTextColor(255, 255, 255);
        this.pdf.text('ONE Movement Inc.', this.margin, 11);

        this.pdf.setFontSize(11);
        this.pdf.text('Dashboard Report', this.margin, 18);

        this.pdf.setFont('helvetica', 'normal');
        this.pdf.setFontSize(10);
        this.pdf.setTextColor(...this.colors.muted);

        this.pdf.text(
            'Generated: ' + new Date().toLocaleString(),
            this.margin,
            31
        );

        this.y = 38;

        this.pdf.setDrawColor(...this.colors.border);

        this.pdf.line(
            this.margin,
            this.y,
            this.pageWidth - this.margin,
            this.y
        );

        this.y += 8;

        this.pdf.setTextColor(...this.colors.text);

    }

    ensureSpace(requiredHeight) {

        if (this.y + requiredHeight <= this.pageHeight - 20) {
            return;
        }

        this.pdf.addPage();
        this.y = 20;

    }

    drawChartCard(title, imgUri, width, height) {

        const cardPadding = 6;
        const cardHeight = cardPadding + 8 + cardPadding + height + cardPadding;

        this.ensureSpace(cardHeight + 8);

        this.pdf.setDrawColor(...this.colors.border);
        this.pdf.setFillColor(255, 255, 255);
        this.pdf.roundedRect(
            this.margin,
            this.y,
            this.contentWidth,
            cardHeight,
            2,
            2,
            'FD'
        );

        this.pdf.setFont('helvetica', 'bold');
        this.pdf.setFontSize(12);
        this.pdf.setTextColor(...this.colors.text);
        this.pdf.text(title, this.margin + cardPadding, this.y + 8);

        this.pdf.setDrawColor(...this.colors.border);
        this.pdf.line(
            this.margin + cardPadding,
            this.y + 10,
            this.margin + this.contentWidth - cardPadding,
            this.y + 10
        );

        const chartX = (this.pageWidth - width) / 2;
        const chartY = this.y + cardPadding + 8 + cardPadding;

        this.pdf.addImage(
            imgUri,
            'PNG',
            chartX,
            chartY,
            width,
            height
        );

        this.y += cardHeight + 8;

    }

    addPageNumbers() {

        const totalPages = this.pdf.getNumberOfPages();

        for (let page = 1; page <= totalPages; page++) {
            this.pdf.setPage(page);
            this.pdf.setFont('helvetica', 'normal');
            this.pdf.setFontSize(9);
            this.pdf.setTextColor(...this.colors.muted);
            this.pdf.text(
                'Page ' + page + ' of ' + totalPages,
                this.pageWidth - this.margin,
                this.pageHeight - 8,
                { align: 'right' }
            );
        }

        this.pdf.setPage(totalPages);
        this.pdf.setTextColor(...this.colors.text);

    }

    startNewPage(title = '') {

        this.pdf.addPage();
        this.y = 20;

        if (title) {
            this.pdf.setFont('helvetica', 'bold');
            this.pdf.setFontSize(12);
            this.pdf.setTextColor(...this.colors.text);
            this.pdf.text(title, this.margin, this.y);

            this.y += 4;
            this.pdf.setDrawColor(...this.colors.border);
            this.pdf.line(this.margin, this.y, this.pageWidth - this.margin, this.y);
            this.y += 6;
        }

    }

    async addChart(title, chartId, type = 'line', size = 'default') {

        let chart;
        let exportOptions = {};

        try {

            if (type === 'bar') {
                // Export bars in higher resolution so long labels stay readable in PDF.
                exportOptions = { scale: 3 };
            } else if (type === 'pie' || type === 'donut') {
                exportOptions = { scale: 2 };
            } else {
                exportOptions = { scale: 2 };
            }

            chart = await this.getChartDataUri(chartId, exportOptions);

        } catch (e) {

            console.error(chartId, e);
            return;

        }

        if (!chart) {
            return;
        }

        let width = 170;
        let height = 85;

        if (type === 'donut' || type === 'pie') {

            width = 130;
            height = 90;

        }

        if (type === 'bar') {

            width = 178;
            height = 125;

        }

        if (size === 'compact') {
            if (type === 'line') {
                width = 172;
                height = 74;
            } else if (type === 'pie' || type === 'donut') {
                width = 122;
                height = 74;
            } else if (type === 'bar') {
                width = 176;
                height = 78;
            }
        }

        this.drawChartCard(title, chart.imgURI, width, height);

    }

    async addChartsPaginated(charts, maxChartsPerPage = 2) {

        if (!Array.isArray(charts) || charts.length === 0) {
            return;
        }

        let chartCountOnCurrentPage = 0;

        for (let index = 0; index < charts.length; index++) {
            const chart = charts[index];

            if (chartCountOnCurrentPage >= maxChartsPerPage) {
                this.startNewPage(chart.pageTitle || '');
                chartCountOnCurrentPage = 0;
            }

            await this.addChart(
                chart.title,
                chart.chartId,
                chart.type || 'line',
                chart.size || 'compact'
            );

            chartCountOnCurrentPage++;
        }

    }

    save() {

        this.addPageNumbers();

        this.pdf.save('Dashboard_Report.pdf');

    }



}

$(function () {

    $('#downloadDashboardPdf').on('click', async function () {

        const button = $(this);
        const originalLabel = button.html();

        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Generating...');

        const report = new DashboardReport();

        try {

            report.header();

            const chartConfigs = [
                {
                    title: 'Registration Trend',
                    chartId: 'registrationTrendChart',
                    type: 'line',
                    size: 'compact'
                },
                {
                    title: 'Registration Type',
                    chartId: 'registrationTypeChart',
                    type: 'pie',
                    size: 'compact'
                },
                {
                    title: 'Members by Region',
                    chartId: 'membersPerRegionChart',
                    type: 'bar',
                    size: 'compact',
                    pageTitle: 'Members Breakdown'
                },
                {
                    title: 'Members by Group',
                    chartId: 'membersPerAllianceChart',
                    type: 'bar',
                    size: 'compact'
                }
            ];

            await report.addChartsPaginated(chartConfigs, 2);

            report.save();
        } finally {
            button.prop('disabled', false);
            button.html(originalLabel);
        }

    });

});
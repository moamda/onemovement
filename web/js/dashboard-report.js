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

        this.y = 20;
    }

    header() {

        this.pdf.setFont('helvetica', 'bold');
        this.pdf.setFontSize(18);
        this.pdf.text('ONE Movement Inc.', this.margin, this.y);

        this.y += 8;

        this.pdf.setFontSize(14);
        this.pdf.text('Dashboard Report', this.margin, this.y);

        this.y += 7;

        this.pdf.setFont('helvetica', 'normal');
        this.pdf.setFontSize(10);

        this.pdf.text(
            'Generated: ' + new Date().toLocaleString(),
            this.margin,
            this.y
        );

        this.y += 10;

        this.pdf.setDrawColor(220);

        this.pdf.line(
            this.margin,
            this.y,
            this.pageWidth - this.margin,
            this.y
        );

        this.y += 10;

    }

    async addChart(title, chartId, type = 'line') {

        let chart;

        try {

            chart = await ApexCharts.exec(chartId, 'dataURI');

        } catch (e) {

            console.error(chartId, e);
            return;

        }

        if (!chart)
            return;

        let width = 170;
        let height = 85;

        if (type === 'donut' || type === 'pie') {

            width = 110;
            height = 80;

        }

        if (this.y + height > this.pageHeight - 20) {

            this.pdf.addPage();
            this.y = 20;

        }

        this.pdf.setFont('helvetica', 'bold');
        this.pdf.setFontSize(12);

        this.pdf.text(title, this.margin, this.y);

        this.y += 5;

        const x = (this.pageWidth - width) / 2;

        this.pdf.addImage(
            chart.imgURI,
            'PNG',
            x,
            this.y,
            width,
            height
        );

        this.y += height + 10;

    }

    save() {

        this.pdf.save('Dashboard_Report.pdf');

    }



}

$(function () {

    $('#downloadDashboardPdf').on('click', async function () {

        const report = new DashboardReport();

        report.header();

        // Gender Chart
        await report.addChart(
            'Gender Distribution',
            'genderDistributionChart',
            'donut'
        );

        // Registration Trend
        await report.addChart(
            'Registration Trend',
            'registrationTrendChart',
            'line'
        );

        report.save();

    });

});
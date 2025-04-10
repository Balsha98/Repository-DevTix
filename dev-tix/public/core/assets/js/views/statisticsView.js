class StatisticsView {
    #statisticsOverviewLabelsLists = $(".statistics-overview-labels-list");
    #chartCanvases = $(".chart-canvas");

    generateStatisticsData(chartsData) {
        let loopCounter = 0;
        for (const [chartTitle, chartLabels] of Object.entries(chartsData)) {
            const chartData = [];
            const chartColors = [];
            let colorID = 0;

            for (const [label, total] of Object.entries(chartLabels)) {
                const colorVar = `--chart-color-${++colorID}`;
                chartColors.push(getComputedStyle(document.documentElement).getPropertyValue(colorVar));
                const colorClass = total === 0 ? "" : colorVar.slice(2);

                $(this.#statisticsOverviewLabelsLists[loopCounter]).append(`
                    <li class="statistics-overview-labels-list-item ${colorClass}">
                        <p>${chartTitle !== "age" ? this.#capitalizeLabel(label) : label}</p>
                        <span>${total}</span>
                    </li>
                `);

                chartData.push(total);
            }

            const dataTotal = chartData.reduce((total, data) => total + data, 0);
            if (dataTotal === 0) $(`.none-chart-${chartTitle}`).removeClass("hide-element");

            this.#loadStatisticsCharts(this.#chartCanvases[loopCounter++], chartData, chartColors);
        }
    }

    #loadStatisticsCharts(chart, data, colors) {
        new Chart(chart, {
            type: "doughnut",
            data: {
                datasets: [
                    {
                        data: data,
                        backgroundColor: colors,
                    },
                ],
            },
            options: {
                plugins: {
                    tooltip: {
                        enabled: false,
                    },
                },
                animation: {
                    duration: 0,
                },
                hover: {
                    mode: null,
                },
            },
        });
    }

    #capitalizeLabel(label) {
        if (label.includes("-")) {
            return label
                .split("-")
                .map((part) => this.#capitalizeLabel(part))
                .join(" ");
        }

        return label[0].toUpperCase() + label.slice(1);
    }
}

export default new StatisticsView();

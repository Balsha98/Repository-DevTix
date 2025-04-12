class LogsView {
    #logsOverviewContainer = $(".div-logs-overview-container");
    #logsSelectFilter = $(".logs-select-filter");
    #logsContainerHeaders = $(".div-logs-overview-container header");
    #logsContainerFooters = $(".div-logs-overview-container footer");
    #logsListOverviewHeader = $(".logs-list-overview-header");
    #logsList = $(".logs-list");
    #spanAppliedFilter = $(".span-applied-filter");
    #spanTotalLogs = $(".span-total-logs");

    generateUsersList(logs, renderImage, getTimeAgo) {
        const containerHeight = parseFloat(this.#logsOverviewContainer.css("height"));

        // prettier-ignore
        const innerElementHeightTotal = [...this.#logsContainerHeaders, this.#logsContainerFooters].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementHeightTotal - 64;
        this.#logsList.css("height", `${elementHeightDifference}px`);

        // Guard clause.
        if (!logs) return;

        // Make sure logs are processed as an array.
        logs = Array.isArray(logs) ? logs : [logs];

        for (const log of logs) {
            this.#logsList.append(`
                <li class="logs-list-item" data-type="${log["type"]}">
                    <div class="div-logs-id-content-container">
                        <p>#${log["log_id"]}</p>
                    </div>
                    <div class="div-logs-user-data-content-container">
                        ${renderImage(log)}
                        <div class="div-logs-user-data-info-container">
                            <p>${log["username"]}</p>
                            <span>${this.#getRoleName(log["role_id"])}</span>
                        </div>
                    </div>
                    <div class="div-logs-data-info-container">
                        <p>${log["title"]}</p>
                        <span>${log["message"]}</span>
                    </div>
                    <div class="div-logs-timestamp-info-container">
                        <p>${getTimeAgo(log["timestamp"])}</p>
                    </div>
                    <div class="div-logs-type-info-container">
                        <p>${log["type"]}</p>
                    </div>
                </li>
            `);
        }

        const listItemsHeightTotal = [...$(".logs-list-item")].reduce((height, item) => {
            return height + parseFloat($(item).css("height"));
        }, 0);

        if (listItemsHeightTotal > elementHeightDifference) {
            this.#logsListOverviewHeader.css("padding-right", "36px");

            this.#logsList.css("padding-right", "12px");
            this.#logsList.css("overflow-y", "scroll");
        }

        this.setSpanTotalLogs(logs.length);
    }

    setSpanFilterName(filter) {
        this.#spanAppliedFilter.text(filter);
    }

    #getRoleName(roleID) {
        if (roleID === 1) return "Administrator";
        else if (roleID === 2) return "Assistant";
        else if (roleID === 3) return "Patron";
    }

    setSpanTotalLogs(totalUsers) {
        this.#spanTotalLogs.text(totalUsers);
    }

    addEventChangeFilter(handlerFunction) {
        this.#logsSelectFilter.change(handlerFunction);
    }
}

export default new LogsView();

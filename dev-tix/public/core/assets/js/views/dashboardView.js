class DashboardView {
    #spanOverviewItems = $(".span-overview-item");
    #dashboardTicketsContainer = $(".div-dashboard-tickets-container");
    #ticketsSelectFilter = $(".tickets-select-filter");
    #ticketsContainerHeaders = $(".div-dashboard-tickets-container header");
    #ticketsContainerFooter = $(".div-dashboard-tickets-container footer");
    #ticketsList = $(".tickets-list");
    #spanAppliedFilter = $(".span-applied-filter");
    #spanTotalTickets = $(".span-total-tickets");

    loadAdminOverviewData(overviews) {
        // Guard clause.
        if (!this.#spanOverviewItems) return;

        this.#spanOverviewItems.each((i, span) => {
            $(span).text(Object.values(overviews)[i]);
        });
    }

    generateTicketsList(tickets, renderImage) {
        const containerHeight = parseFloat(this.#dashboardTicketsContainer.css("height"));

        // prettier-ignore
        const innerElementHeightTotal = [...this.#ticketsContainerHeaders, this.#ticketsContainerFooter].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementHeightTotal;
        this.#ticketsList.css("height", `calc(${elementHeightDifference}px - 64px)`);

        // Guard clause.
        if (!tickets) return;

        // Make sure tickets are processed as an array.
        tickets = Array.isArray(tickets) ? tickets : [tickets];

        for (const { ticket, patron, assistant } of tickets) {
            const isEmpty = assistant.length === 0;
            const assistantName = isEmpty ? "Not Yet Assigned" : `${assistant["first_name"]} ${assistant["last_name"]}`;
            const assistantEmail = isEmpty ? "To Be Assigned" : assistant["email"];

            this.#ticketsList.append(`
                <li 
                    class="tickets-list-item" 
                    data-href="ticket/${ticket["request_id"]}" 
                    data-status="${ticket["status"]}"
                >
                    <div class="div-tickets-id-content-container">
                        <p>#${ticket["request_id"]}</p>
                    </div>
                    <div class="div-tickets-patron-content-container">
                        ${renderImage(patron)}
                        <div class="div-tickets-patron-info-container">
                            <p>${patron["first_name"]} ${patron["last_name"]}</p>
                            <span>${patron["email"]}</span>
                        </div>
                    </div>
                    <div class="div-tickets-subject-info-container">
                        <p>${ticket["subject"]}</p>
                        <span>${ticket["type"]}</span>
                    </div>
                    <div class="div-tickets-assistant-info-container">
                        <p>${assistantName}</p>
                        <span>${assistantEmail}</span>
                    </div>
                    <div class="div-tickets-status-info-container status-${ticket["status"]}">
                        <p>${ticket["status"]}</p>
                    </div>
                </li>    
            `);
        }

        this.setSpanTotalTickets(tickets.length);
    }

    setSpanFilterName(filter) {
        this.#spanAppliedFilter.text(filter[0].toUpperCase() + filter.slice(1));
    }

    setSpanTotalTickets(totalTickets) {
        this.#spanTotalTickets.text(totalTickets);
    }

    addEventViewTicketDetails(handlerFunction) {
        const ticketListItems = $(".tickets-list-item");

        // Guard clause.
        if (ticketListItems.length === 0) return;

        ticketListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }

    addEventChangeFilter(handlerFunction) {
        this.#ticketsSelectFilter.change(handlerFunction);
    }
}

export default new DashboardView();

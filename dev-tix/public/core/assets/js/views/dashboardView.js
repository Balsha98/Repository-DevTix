class DashboardView {
    #dashboardTicketsContainer = $(".div-dashboard-tickets-container");
    #ticketsContainerHeaders = $(".div-dashboard-tickets-container header");
    #ticketsContainerFooter = $(".div-dashboard-tickets-container footer");
    #ticketsList = $(".tickets-list");
    #spanTotalTickets = $(".span-total-tickets");

    generateTicketsList(data, renderImage) {
        const containerHeight = parseFloat(this.#dashboardTicketsContainer.css("height"));

        // prettier-ignore
        const innerElementHeightTotal = [...this.#ticketsContainerHeaders, this.#ticketsContainerFooter].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementHeightTotal;
        this.#ticketsList.css("height", `calc(${elementHeightDifference}px - 64px)`);

        // Make sure data is processed as an array.
        data = Array.isArray(data) ? data : [data];

        for (const { ticket, patron, assistant } of data) {
            this.#ticketsList.append(`
                <li class="tickets-list-item" data-href="ticket/${ticket["request_id"]}">
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
                        <p>${assistant["first_name"]} ${assistant["last_name"]}</p>
                        <span>${assistant["email"]}</span>
                    </div>
                    <div class="div-tickets-status-info-container status-${ticket["status"]}">
                        <p>${ticket["status"]}</p>
                    </div>
                </li>    
            `);
        }

        this.#spanTotalTickets.text(data.length);
    }

    addEventViewTicketDetails(handlerFunction) {
        $(".tickets-list-item").each((_, item) => {
            $(item).click(handlerFunction);
        });
    }
}

export default new DashboardView();

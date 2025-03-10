class DashboardView {
    #dashboardTicketsContainer = $(".div-dashboard-tickets-container");
    #ticketsContainerHeaders = $(".div-dashboard-tickets-container header");
    #ticketsContainerFooter = $(".div-dashboard-tickets-container footer");
    #ticketsList = $(".tickets-list");
    #spanTotalTickets = $(".span-total-tickets");

    generateTicketsList(tickets) {
        const containerHeight = parseFloat(this.#dashboardTicketsContainer.css("height"));

        // prettier-ignore
        const innerElementHeightTotal = [...this.#ticketsContainerHeaders, this.#ticketsContainerFooter].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementHeightTotal;
        this.#ticketsList.css("height", `calc(${elementHeightDifference}px - 48px)`);

        for (const ticket of tickets) {
            this.#ticketsList.append(`
                <li class="tickets-list-item" data-href="/ticket/{id}">
                    <div class="div-tickets-patron-content-container">
                        <div class="div-image-container div-tickets-patron-image-container">
                            <img src="" alt="User Image">
                        </div>
                        <div class="div-tickets-patron-info-container">
                            <p>Patron's Name</p>
                            <span>Email Address</span>
                        </div>
                    </div>
                    <div class="div-tickets-subject-info-container">
                        <p>Ticket Title</p>
                        <span>Ticket Type</span>
                    </div>
                    <div class="div-tickets-assistant-info-container">
                        <p>Assistant's Name</p>
                        <span>Email Address</span>
                    </div>
                    <div class="div-tickets-status-info-container">
                        <p>Completed</p>
                    </div>
                </li>    
            `);
        }

        this.#spanTotalTickets.text(tickets.length);
    }
}

export default new DashboardView();

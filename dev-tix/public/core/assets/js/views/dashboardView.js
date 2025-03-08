class DashboardView {
    #spanWelcomeMessage = $(".span-welcome-message");
    #btnsIcon = $(".btn-nav-icon");

    setWelcomeMessage() {
        const hours = new Date().getHours();

        let timeOfDay;
        if (hours < 12) timeOfDay = "morning";
        else if (hours >= 12 && hours <= 18) timeOfDay = "afternoon";
        else timeOfDay = "evening";

        this.#spanWelcomeMessage.text(`Good ${timeOfDay}`);
    }

    addEventToggleDropdown(handlerFunction) {
        this.#btnsIcon.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }
}

export default new DashboardView();

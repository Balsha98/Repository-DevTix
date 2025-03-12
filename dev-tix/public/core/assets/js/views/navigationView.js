class NavigationView {
    #spanWelcomeMessage = $(".span-welcome-message");
    #spanNotificationsIndicator = $(".span-notifications-indicator");
    #spanTotalUnread = $(".span-total-unread");
    #notificationsMenuList = $(".notifications-menu-list");
    #btnsIcon = $(".btn-nav-icon");
    #btnMarkAsRead = $(".btn-mark-as-read");

    setWelcomeMessage() {
        const hours = new Date().getHours();

        let timeOfDay;
        if (hours < 12) timeOfDay = "morning";
        else if (hours >= 12 && hours <= 18) timeOfDay = "afternoon";
        else timeOfDay = "evening";

        this.#spanWelcomeMessage.text(`Good ${timeOfDay}`);
    }

    generateNotificationsList(data) {
        const isArray = Array.isArray(data["notifications"]);
        const notifications = isArray ? data["notifications"] : [data["notifications"]];
        const totalUnread = data["total_unread"]["total"];

        // Remove certain visuals.
        if (totalUnread === 0) {
            this.#spanNotificationsIndicator.remove();
            this.#btnMarkAsRead.remove();
        }

        for (const item of notifications) {
            const isUnread = item["is_read"] === 0 ? "unread-notification" : "";

            this.#notificationsMenuList.append(`
                <li class="dropdown-menu-list-item notifications-menu-list-item ${isUnread}">
                    <div class="div-notifications-icon-container flex-center">
                        <ion-icon src="/core/assets/media/icons/${this.#getIconType(item["type"])}.svg"></ion-icon>
                    </div>
                    <div class="div-notifications-info-container">
                        <h4>${item["title"]}</h4>
                        <span>Time Ago</span>
                    </div>
                </li>    
            `);
        }

        // Add scroll overflow to list.
        if (notifications.length > 5) this.#notificationsMenuList.css("overflow-y", "scroll");

        this.#spanTotalUnread.text(totalUnread);
    }

    #getIconType(type) {
        if (type === "signup") return "user-plus";
        else if (type === "profile") return "user";
        else if (type === "request") return "paperclip";
        else if (type === "response") return "wind";
        else if (type === "league") return "award";
        else if (type === "leaderboard") return "chart";
    }

    addEventToggleDropdown(handlerFunction) {
        this.#btnsIcon.each((_, btn) => {
            $(btn).click(handlerFunction);
        });
    }

    addEventMarkNotificationsAsRead(handlerFunction) {
        this.#btnMarkAsRead.click(handlerFunction);
    }

    addEventViewNotificationDetails(handlerFunction) {
        $(".notification-list-item").each((_, item) => {
            $(item).click(handlerFunction);
        });
    }
}

export default new NavigationView();

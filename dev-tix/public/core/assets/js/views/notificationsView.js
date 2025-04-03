class NotificationsView {
    #notificationsContentContainer = $(".div-notifications-content-container");
    #notificationsContainerHeader = $(".notifications-container-header");
    #notificationsContainerFooter = $(".notifications-container-footer");
    #notificationsSelectFilter = $(".notifications-select-filter");
    #btnMarkAll = $(".btn-mark-all");
    #notificationsListOverviewHeader = $(".notifications-list-overview-header");
    #notificationsList = $(".notifications-list");
    #spanAppliedFilter = $(".span-applied-filter");
    #spanTotalNotifications = $(".span-total-notifications");

    generateNotificationsList(notifications, renderImage, getTimeAgo) {
        const containerHeight = parseFloat(this.#notificationsContentContainer.css("height"));

        // prettier-ignore
        const innerElementHeightTotal = [
            this.#notificationsContainerHeader, 
            this.#notificationsListOverviewHeader,
            this.#notificationsContainerFooter
        ].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementHeightTotal - 64;
        this.#notificationsList.css("height", `${elementHeightDifference}px`);

        // Guard clause.
        if (!notifications || notifications.length === 0) return;

        // Make sure notifications are processed as an array.
        notifications = Array.isArray(notifications) ? notifications : [notifications];

        for (const notification of notifications) {
            const read = notification["is_read"] === 1 ? "read" : "unread";

            this.#notificationsList.append(`
                <li 
                    class="notifications-list-item" 
                    data-notification-id="${notification["notification_id"]}" 
                    data-status="${notification["is_read"]}" 
                    data-method="PUT"
                >
                    <div class="div-notifications-id-content-container">
                        <p>#${notification["notification_id"]}</p>
                    </div>
                    <div class="div-notifications-user-content-container">
                        ${renderImage(notification)}
                        <div class="div-notifications-user-info-container">
                            <p>${notification["username"]}</p>
                            <span>${notification["email"]}</span>
                        </div>
                    </div>
                    <div class="div-notifications-content-info-container">
                        <p>${notification["title"]}</p>
                        <span>${notification["message"]}</span>
                    </div>
                    <div class="div-notifications-timestamp-info-container">
                        <p>${getTimeAgo(notification["sent_at"])}</p>
                    </div>
                    <div class="div-notifications-status-info-container status-${read}">
                        <p>${read[0].toUpperCase() + read.slice(1)}</p>
                    </div>
                </li>
            `);
        }

        const listItemsHeightTotal = [...$(".notifications-list-item")].reduce((height, item) => {
            return height + parseFloat($(item).css("height"));
        }, 0);

        if (listItemsHeightTotal > elementHeightDifference) {
            this.#notificationsListOverviewHeader.css("padding-right", "36px");

            this.#notificationsList.css("padding-right", "12px");
            this.#notificationsList.css("overflow-y", "scroll");
        }

        this.setSpanTotalNotifications(notifications.length);
    }

    setSpanFilterName(filter) {
        const filterName = isNaN(filter) ? filter : filter ? "read" : "unread";
        this.#spanAppliedFilter.text(filterName[0].toUpperCase() + filterName.slice(1));
    }

    setSpanTotalNotifications(totalNotifications) {
        this.#spanTotalNotifications.text(totalNotifications);
    }

    addEventChangeFilter(handlerFunction) {
        this.#notificationsSelectFilter.change(handlerFunction);
    }

    addEventMarkAllAsRead(handlerFunction) {
        this.#btnMarkAll.click(handlerFunction);
    }

    addEventMarkNotificationAsRead(handlerFunction) {
        const notificationListItems = $(".notifications-list-item");

        // Guard clause.
        if (notificationListItems.length === 0) return;

        notificationListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }
}

export default new NotificationsView();

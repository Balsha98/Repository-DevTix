class UsersView {
    #usersOverviewContainer = $(".div-users-overview-container");
    #usersSelectFilter = $(".users-select-filter");
    #usersContainerHeaders = $(".div-users-overview-container header");
    #usersContainerFooters = $(".div-users-overview-container footer");
    #usersListOverviewHeader = $(".users-list-overview-header");
    #usersList = $(".users-list");
    #spanAppliedFilter = $(".span-applied-filter");
    #spanTotalUsers = $(".span-total-users");

    generateUsersList(users, renderImage, getTimeAgo) {
        const containerHeight = parseFloat(this.#usersOverviewContainer.css("height"));

        // prettier-ignore
        const innerElementHeightTotal = [...this.#usersContainerHeaders, this.#usersContainerFooters].reduce(
            (height, element) => height + parseFloat($(element).css("height")), 0
        );

        const elementHeightDifference = containerHeight - innerElementHeightTotal - 64;
        this.#usersList.css("height", `${elementHeightDifference}px`);

        // Guard clause.
        if (!users) return;

        // Make sure users are processed as an array.
        users = Array.isArray(users) ? users : [users];

        for (const user of users) {
            const [length, timeOfDay] = getTimeAgo(user["last_active"]).split(" ");
            const activity = length >= 30 && timeOfDay.includes("Day") ? "inactive" : "active";

            this.#usersList.append(`
                <li 
                    class="users-list-item" 
                    data-role-id="${user["role_id"]}" 
                    data-href="profile/${user["user_id"]}" 
                    data-activity="${activity}"
                >
                    <div class="div-users-id-content-container">
                        <p>#${user["user_id"]}</p>
                    </div>
                    <div class="div-users-data-content-container">
                        ${renderImage(user)}
                        <div class="div-users-data-info-container">
                            <p>${user["username"]}</p>
                            <span>${this.#getRoleName(user["role_id"])}</span>
                        </div>
                    </div>
                    <div class="div-users-full-name-info-container">
                        <p>${user["first_name"]} ${user["last_name"]}</p>
                    </div>
                    <div class="div-users-email-info-container">
                        <a href="mailto:${user["email"]}">${user["email"]}</a>
                    </div>
                    <div class="div-users-activity-info-container status-${activity}">
                        <p>${activity[0].toUpperCase() + activity.slice(1)}</p>
                    </div>
                </li>
            `);
        }

        const listItemsHeightTotal = [...$(".users-list-item")].reduce((height, item) => {
            return height + parseFloat($(item).css("height"));
        }, 0);

        if (listItemsHeightTotal > elementHeightDifference) {
            this.#usersListOverviewHeader.css("padding-right", "36px");

            this.#usersList.css("padding-right", "12px");
            this.#usersList.css("overflow-y", "scroll");
        }

        this.setSpanTotalUsers(users.length);
    }

    setSpanFilterName(filter) {
        const roleName = this.#getRoleName(filter);
        this.#spanAppliedFilter.text(roleName);
    }

    #getRoleName(roleID) {
        if (roleID === 1) return "Administrator";
        else if (roleID === 2) return "Assistant";
        else if (roleID === 3) return "Patron";
        else return "All";
    }

    setSpanTotalUsers(totalUsers) {
        this.#spanTotalUsers.text(totalUsers);
    }

    addEventViewUserProfile(handlerFunction) {
        const usersListItems = $(".users-list-item");

        // Guard clause.
        if (usersListItems.length === 0) return;

        usersListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }

    addEventChangeFilter(handlerFunction) {
        this.#usersSelectFilter.change(handlerFunction);
    }
}

export default new UsersView();

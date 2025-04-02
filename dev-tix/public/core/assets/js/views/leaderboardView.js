class LeaderboardView {
    #leaderboardContentContainer = $(".div-leaderboard-content-container");
    #leaderboardContentHeader = $(".leaderboard-content-header");
    #leaderboardContentFooter = $(".leaderboard-content-footer");
    #leaderboardSelectType = $(".leaderboard-select-type");
    #assistantsListContainers = $(".div-assistants-list-container");
    #leaderboardOverviewHeaders = $(".leaderboard-overview-header");
    #assistantsLists = $(".assistants-list");
    #spansLeaderboardType = $(".span-leaderboard-type");

    setTargetLeaderboardAsMain(leagueType) {
        this.#assistantsListContainers.each((_, container) => {
            const listLeagueType = $(container).data("league-type");
            if (listLeagueType !== leagueType) $(container).addClass("hide-element");
            else $(container).removeClass("hide-element");
        });

        this.#leaderboardSelectType.val(leagueType);
        this.setSpansLeaderboardType(leagueType);
    }

    generateLeaderboardsData(data, renderImage, getTimeAgo) {
        const containerHeight = parseFloat(this.#leaderboardContentContainer.css("height"));

        const elementHeightDifferences = [];
        this.#assistantsListContainers.each((i, container) => {
            const leagueType = $(container).data("league-type");

            // prettier-ignore
            const innerElementHeightTotal = [
                this.#leaderboardContentHeader, 
                $(`.${leagueType}-overview-header`), 
                this.#leaderboardContentFooter
            ].reduce(
                (height, element) => height + parseFloat($(element).css("height")), 0
            );

            elementHeightDifferences.push(containerHeight - innerElementHeightTotal - 64);
            $(`.${leagueType}-list`).css("height", `${elementHeightDifferences[i]}px`);
        });

        // Guard clause.
        if (!data || data.length === 0) return;

        let position = 0;
        for (const [leagueType, assistants] of Object.entries(data)) {
            for (const assistant of assistants) {
                const [length, timeOfDay] = assistant["last_active"].split(" ");
                const activity = length >= 30 && timeOfDay.includes("Day") ? "inactive" : "active";

                $(`.${leagueType}-list`).append(`
                    <li 
                        class="assistants-list-item" 
                        data-href="profile/${assistant["user_id"]}" 
                        data-activity="${activity}"
                    >
                        <div class="div-assistants-position-content-container">
                            <p>#${++position}</p>
                        </div>
                        <div class="div-assistants-data-content-container">
                            ${renderImage(assistant)}
                            <div class="div-assistants-data-info-container">
                                <p>${assistant["username"]}</p>
                                <span>${assistant["role_name"]}</span>
                            </div>
                        </div>
                        <div class="div-assistants-email-info-container">
                            <a href="mailto:${assistant["email"]}">${assistant["email"]}</a>
                        </div>
                        <div class="div-assistants-tickets-info-container">
                            <p>${assistant["resolved_tickets"]}</p>
                        </div>
                        <div class="div-assistants-activity-info-container status-${activity}">
                            <p>${activity[0].toUpperCase() + activity.slice(1)}</p>
                        </div>
                    </li>
                `);
            }

            position = 0;
        }

        this.#assistantsListContainers.each((i, container) => {
            const leagueType = $(container).data("league-type");
            const currListItems = $(`.${leagueType}-list li`);

            const listItemsHeightTotal = [...currListItems].reduce((height, item) => {
                return height + parseFloat($(item).css("height"));
            }, 0);

            if (listItemsHeightTotal > elementHeightDifferences[i]) {
                $(`.${leagueType}-overview-header`).css("padding-right", "36px");

                const currAssistantsList = $(`.${leagueType}-list`);
                currAssistantsList.css("padding-right", "12px");
                currAssistantsList.css("overflow-y", "scroll");
            }
        });
    }

    setSpansLeaderboardType(leagueType) {
        this.#spansLeaderboardType.each((_, span) => {
            $(span).text(leagueType[0].toUpperCase() + leagueType.slice(1));
        });
    }

    addEventChangeLeaderboardType(handlerFunction) {
        this.#leaderboardSelectType.change(handlerFunction);
    }

    addEventViewUserProfile(handlerFunction) {
        const assistantsListItems = $(".assistants-list-item");

        // Guard clause: none exist.
        if (assistantsListItems.length === 0) return;

        assistantsListItems.each((_, item) => {
            $(item).click(handlerFunction);
        });
    }
}

export default new LeaderboardView();

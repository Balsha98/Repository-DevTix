import * as pageLoaderController from "./pageLoaderController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import leaderboardView from "./../views/leaderboardView.js";

const controlChangeLeaderboardType = function () {
    const assistantsLists = $(".assistants-list");
    dataLoaderController.controlShowDataLoader();

    // Verify type.
    const leagueType = $(this).val();
    assistantsLists.each((_, list) => {
        const listLeagueType = $(list).data("league-type");
        if (listLeagueType !== leagueType) $(list).addClass("hide-element");
        else $(list).removeClass("hide-element");
    });

    leaderboardView.setSpansLeaderboardType(leagueType);

    // Hide data loader.
    dataLoaderController.controlHideDataLoader(1);
};

const controlGetLeaderboardsData = function () {
    const leagueType = $("#league").val();
    leaderboardView.setTargetLeaderboardAsMain(leagueType);

    const route = $("#view").val();
    const authToken = $("#csrf_token").val();
    const url = `/api/?route=${route}&csrf_token=${authToken}`;
    const method = "GET";

    $.ajax({
        url: url,
        method: method,
        success: function (response) {},
        error: function (response) {
            console.log(response.responseText);
        },
    });
};

const controlViewUserProfile = function () {
    const href = $(this).data("href");
    const activity = $(this).data("activity");

    if (activity === "active") redirectTo(href);
};

const initController = function () {
    pageLoaderController.controlHidePageLoader(0.1);

    // Setup navigation.
    navigationView.setWelcomeMessage();
    navigationController.controlGenerateNavigationLists();
    navigationView.addEventToggleDropdown(navigationController.controlToggleDropdown);
    navigationView.addEventRevertClientData(navigationController.controlRevertClientData);
    navigationView.addEventMarkNotificationsAsRead(navigationController.controlMarkNotificationsAsRead);

    // Setup sidebar.
    sidebarView.addEventToggleSidebar(sidebarController.controlToggleSidebar);
    sidebarView.addEventToggleSidebarDropdown(sidebarController.controlToggleSidebarDropdown);

    // Setup leaderboard.
    leaderboardView.addEventChangeLeaderboardType(controlChangeLeaderboardType);
    controlGetLeaderboardsData();
};

initController();

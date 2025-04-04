import { redirectTo } from "./../helpers/redirect.js";
import { renderListItemUserImage } from "./../helpers/image.js";
import { getTimeAgo } from "./../helpers/date.js";
import * as pageLoaderController from "./pageLoaderController.js";
import * as dataLoaderController from "./dataLoaderController.js";
import navigationView from "./../views/navigationView.js";
import * as navigationController from "./navigationController.js";
import sidebarView from "./../views/sidebarView.js";
import * as sidebarController from "./sidebarController.js";
import leaderboardView from "./../views/leaderboardView.js";
import * as noneDataController from "./noneDataController.js";

const controlChangeLeaderboardType = function () {
    const assistantsListContainer = $(".div-assistants-list-container");

    // Show visuals.
    noneDataController.controlHideNoneDataContainer();
    dataLoaderController.controlShowDataLoader();

    // Verify type.
    const leagueType = $(this).val();
    assistantsListContainer.each((_, container) => {
        const containerLeagueType = $(container).data("league-type");
        if (containerLeagueType !== leagueType) $(container).addClass("hide-element");
        else $(container).removeClass("hide-element");
    });

    leaderboardView.setSpansLeaderboardType(leagueType);
    leaderboardView.setLeagueIcon(leagueType);

    // Calculate visible assistants.
    const totalAssistantsLeft = $(`.${leagueType}-list li`).length;
    if (totalAssistantsLeft === 0) noneDataController.controlShowNoneDataContainer(1);

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
        success: function (response) {
            console.log(route, response);

            // Calculate visible assistants.
            const listData = response["response"]["data"];
            if (!listData[leagueType] || listData.length === 0) noneDataController.controlShowNoneDataContainer();

            leaderboardView.generateLeaderboardsData(listData, renderListItemUserImage, getTimeAgo);
            leaderboardView.addEventViewUserProfile(controlViewUserProfile);
        },
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
    pageLoaderController.controlHidePageLoader(1);

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

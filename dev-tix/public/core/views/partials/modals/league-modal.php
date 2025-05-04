    <!-- LEAGUE MODAL CONTAINER -->
    <div class="div-league-modal-container absolute-center hide-league-modal">
        <div class="div-league-modal absolute-center">
            <button class="btn btn-icon btn-close-league-modal">
                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
            </button>
            <div class="div-league-modal-status-container">
                <div class="div-league-modal-status-circle">
                    <header class="league-modal-status-circle-header absolute-center">
                        <p>Next League</p>
                        <span><?php echo $leaderboard->getNextLeagueName(); ?></span>
                    </header>
                </div>
                <p class="text-league-modal-status-progress">
                    Progress: <span class="span-league-progress">
                        <?php echo $leaderboard->getLeagueProgress(); ?>%
                    </span>
                </p>
            </div>
            <div class="div-league-modal-overview-container">
                <header class="league-modal-header">
                    <h2>League Ranking Overview</h2>
                </header>
                <ul class="league-modal-data-list">
                    <li class="league-modal-data-list-item">
                        <p>League Status:</p>
                        <span><?php echo $leaderboard->getLeagueName(); ?></span>
                    </li>
                    <li class="league-modal-data-list-item">
                        <p>Resolved Tickets:</p>
                        <span><?php echo $leaderboard->getResolvedTickets(); ?></span>
                    </li>
                    <li class="league-modal-data-list-item">
                        <p>League Rank:</p>
                        <span class="span-league-rank">
                            <?php echo $leaderboard->getLeagueRank(); ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

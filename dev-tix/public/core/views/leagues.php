<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/loaders/page-loader.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- LEAGUES CONTAINER -->
            <div class="div-leagues-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <ul class="leagues-overview-list grid-2-columns">
                    <li class="leagues-overview-list-item">
                        <div class="div-league-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/legend.svg"></ion-icon>
                        </div>
                        <div class="div-league-overview-info-container legendary-info">
                            <p>Solved Tickets: <span>500+</span></p>
                            <h2>Legendary</h2>
                        </div>
                        <div class="div-league-overview-leader-container legendary-leader">
                            <span>Leading The Way</span>
                            <p>Assistant Username</p>
                        </div>
                        <div class="div-leaderboard-link-container flex-center">
                            <a class="link link-white flex-center" href="/leaderboard/?league=legendary">
                                <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"></ion-icon>
                                <span>View Standings</span>
                            </a>
                        </div>
                    </li>
                    <li class="leagues-overview-list-item">
                        <div class="div-league-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/senior.svg"></ion-icon>
                        </div>
                        <div class="div-league-overview-info-container">
                            <p>Solved Tickets: <span>250+</span></p>
                            <h2>Senior League</h2>
                        </div>
                        <div class="div-league-overview-leader-container">
                            <span>Leading The Way</span>
                            <p>Assistant Username</p>
                        </div>
                        <div class="div-leaderboard-link-container flex-center">
                            <a class="link link-white flex-center" href="/leaderboard/?league=senior">
                                <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"></ion-icon>
                                <span>View Standings</span>
                            </a>
                        </div>
                    </li>
                    <li class="leagues-overview-list-item">
                        <div class="div-league-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/junior.svg"></ion-icon>
                        </div>
                        <div class="div-league-overview-info-container">
                            <p>Solved Tickets: <span>100+</span></p>
                            <h2>Junior League</h2>
                        </div>
                        <div class="div-league-overview-leader-container">
                            <span>Leading The Way</span>
                            <p>Assistant Username</p>
                        </div>
                        <div class="div-leaderboard-link-container flex-center">
                            <a class="link link-white flex-center" href="/leaderboard/?league=junior">
                                <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"></ion-icon>
                                <span>View Standings</span>
                            </a>
                        </div>
                    </li>
                    <li class="leagues-overview-list-item">
                        <div class="div-league-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/rookie.svg"></ion-icon>
                        </div>
                        <div class="div-league-overview-info-container">
                            <p>Solved Tickets: <span>10+</span></p>
                            <h2>Rookie League</h2>
                        </div>
                        <div class="div-league-overview-leader-container">
                            <span>Leading The Way</span>
                            <p>Assistant Username</p>
                        </div>
                        <div class="div-leaderboard-link-container flex-center">
                            <a class="link link-white flex-center" href="/leaderboard/?league=rookie">
                                <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"></ion-icon>
                                <span>View Standings</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/leagues">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
            </div>
        </main>
    </div>

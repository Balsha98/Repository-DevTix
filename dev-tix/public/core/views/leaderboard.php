<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/loaders/page-loader.php';
require_once __DIR__ . '/partials/modals/alert-modal.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- LEADERBOARD CONTAINER -->
            <div class="div-leaderboard-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-leaderboard-content-container">
                    <header class="leaderboard-content-header flex-between">
                        <h2 class="leaderboard-content-header-heading">
                            <span class="span-leaderboard-type">Legendary</span> Leaderboard Overview
                        </h2>
                        <div class="div-leaderboard-actions-container">
                            <div class="div-input-container">
                                <label class="label-select absolute-y-center" for="type">
                                    <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                </label>
                                <select id="type" class="leaderboard-select-type" name="type">
                                    <option value="legendary">Show Legendary</option>
                                    <option value="senior">Show Senior</option>
                                    <option value="junior">Show Junior</option>
                                    <option value="rookie">Show Rookie</option>
                                </select>
                            </div>
                        </div>
                    </header>
                    <div class="div-leaderboard-overview-container">
                        <header class="leaderboard-overview-header">
                            <p>Position</p>
                            <p>User</p>
                            <p>Email Address</p>
                            <p>Tickets</p>
                            <p>Activity</p>
                        </header>
                        <div class="div-assistants-lists-container">
                            <?php require_once __DIR__ . '/partials/loaders/data-loader.php'; ?>
                            <ul class="assistants-list" data-league-type="legendary">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                                <!-- <li class="assistants-list-item" data-href="profile/1" data-activity="">
                                    <div class="div-assistants-position-content-container">
                                        <p>#1</p>
                                    </div>
                                    <div class="div-assistants-data-content-container">
                                        <img src="" alt="">
                                        <div class="div-assistants-data-info-container">
                                            <p>Username</p>
                                            <span>Role Name</span>
                                        </div>
                                    </div>
                                    <div class="div-assistants-email-info-container">
                                        <a href="mailto:">email address</a>
                                    </div>
                                    <div class="div-assistants-tickets-info-container">
                                        <p>500</p>
                                    </div>
                                    <div class="div-assistants-activity-info-container status-active">
                                        <p>Legendary</p>
                                    </div>
                                </li> -->
                            </ul>
                            <ul class="assistants-list hide-element" data-league-type="senior">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                            <ul class="assistants-list hide-element" data-league-type="junior">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                            <ul class="assistants-list hide-element" data-league-type="rookie">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                        </div>
                    </div>
                    <footer class="leaderboard-content-footer flex-between">
                        <p>Leaderboard: <span class="span-leaderboard-type">Legendary</span></p>
                        <p>Viewing Since: <span><?php echo date('H:i'); ?></span></p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/leaderboard">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                <input id="league" type="hidden" name="league" value="<?php echo $_GET['league'] ?? 'legendary'; ?>">
            </div>
        </main>
    </div>

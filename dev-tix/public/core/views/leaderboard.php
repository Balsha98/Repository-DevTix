<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/loaders/page-loader.php';
require_once __DIR__ . '/partials/modals/logout-modal.php';
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
                            <div class="div-league-icon-container flex-center">
                                <ion-icon class="icon-league" src="<?php echo ICON_PATH; ?>/legendary.svg"></ion-icon>
                            </div>
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
                        <?php require_once __DIR__ . '/partials/signs/none-data.php'; ?>
                        <?php require_once __DIR__ . '/partials/loaders/data-loader.php'; ?>
                        <div class="div-assistants-list-container" data-league-type="legendary">
                            <header class="leaderboard-overview-header legendary-overview-header">
                                <p>Position</p>
                                <p>User</p>
                                <p>Email Address</p>
                                <p>Tickets</p>
                                <p>Activity</p>
                            </header>
                            <ul class="assistants-list legendary-list">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-assistants-list-container" data-league-type="senior">
                            <header class="leaderboard-overview-header senior-overview-header">
                                <p>Position</p>
                                <p>User</p>
                                <p>Email Address</p>
                                <p>Tickets</p>
                                <p>Activity</p>
                            </header>
                            <ul class="assistants-list senior-list">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-assistants-list-container" data-league-type="junior">
                            <header class="leaderboard-overview-header junior-overview-header">
                                <p>Position</p>
                                <p>User</p>
                                <p>Email Address</p>
                                <p>Tickets</p>
                                <p>Activity</p>
                            </header>
                            <ul class="assistants-list junior-list">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-assistants-list-container" data-league-type="rookie">
                            <header class="leaderboard-overview-header rookie-overview-header">
                                <p>Position</p>
                                <p>User</p>
                                <p>Email Address</p>
                                <p>Tickets</p>
                                <p>Activity</p>
                            </header>
                            <ul class="assistants-list rookie-list">
                                <!-- DYNAMICALLY GENERATED ASSISTANTS VIA AJAX -->
                            </ul>
                        </div>
                    </div>
                    <footer class="leaderboard-content-footer flex-between">
                        <p>Leaderboard: <span class="span-leaderboard-type">Legendary</span></p>
                        <p>Viewing Since: <span><?php echo date('H:i a'); ?></span></p>
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

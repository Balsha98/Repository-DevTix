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
                            <span class="span-current-leaderboard">Legendary</span> Leaderboard Overview
                        </h2>
                        <div class="div-pagination-btns-container">
                            <button class="btn btn-primary btn-pagination" data-direction="prev">
                                <ion-icon src="<?php echo ICON_PATH; ?>/chevron-left.svg"></ion-icon>
                            </button>
                            <button class="btn btn-primary btn-pagination" data-direction="next">
                                <ion-icon src="<?php echo ICON_PATH; ?>/chevron-right.svg"></ion-icon>
                            </button>
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
                        <div class="div-leaderboard-lists-container">
                            <ul class="">
                                <!-- DYNAMICALLY GENERATED USERS VIA AJAX -->
                            </ul>
                            <ul class="">
                                <!-- DYNAMICALLY GENERATED USERS VIA AJAX -->
                            </ul>
                            <ul class="">
                                <!-- DYNAMICALLY GENERATED USERS VIA AJAX -->
                            </ul>
                            <ul class="">
                                <!-- DYNAMICALLY GENERATED USERS VIA AJAX -->
                            </ul>
                        </div>
                    </div>
                    <footer class="leaderboard-content-footer flex-between">
                        <p>Leaderboard: <span class="span-current-leaderboard">Legendary</span></p>
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

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
            <!-- NOTIFICATIONS CONTAINER -->
            <div class="div-notifications-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-notifications-content-container">
                    <header class="notifications-container-header flex-between">
                        <h2 class="notifications-container-header-heading">
                            <span class="span-client-username"><?php echo $user->getUsername(); ?></span>'s Notifications Overview
                        </h2>
                        <div class="div-notifications-actions-container">
                            <div class="div-input-container">
                                <label class="label-select absolute-y-center" for="filter">
                                    <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                </label>
                                <select id="filter" class="notifications-select-filter" name="filter">
                                    <option value="all">Filter All</option>
                                    <option value="0">Filter Unread</option>
                                    <option value="1">Filter Read</option>
                                </select>
                            </div>
                            <button class="btn btn-primary btn-mark-all" data-method="PUT">
                                <ion-icon src="<?php echo ICON_PATH; ?>/check.svg"></ion-icon>
                                <span>Mark All</span>
                            </button>
                        </div>
                    </header>
                    <div class="div-notifications-list-overview-container">
                        <header class="notifications-list-overview-header">
                            <p>#ID</p>
                            <p>User</p>
                            <p>Content</p>
                            <p>Time Ago</p>
                            <p>Status</p>
                        </header>
                        <div class="div-notifications-list-container">
                            <?php require_once __DIR__ . '/partials/signs/none-data.php'; ?>
                            <?php require_once __DIR__ . '/partials/loaders/data-loader.php'; ?>
                            <ul class="notifications-list">
                                <!-- DYNAMICALLY GENERATED TICKETS VIA AJAX -->
                            </ul>
                        </div>
                    </div>
                    <footer class="notifications-container-footer flex-between">
                        <p>Applied Filter: <span class="span-applied-filter">All</span></p>
                        <p>Viewing <span class="span-total-notifications">0</span> total notifications.</p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/notifications">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
            </div>
        </main>
    </div>

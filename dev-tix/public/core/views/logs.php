<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/loaders/page-loader.php';
require_once __DIR__ . '/partials/modals/alert-modal.php';
require_once __DIR__ . '/partials/modals/logout-modal.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- LOGS CONTAINER -->
            <div class="div-logs-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-logs-overview-container">
                    <header class="logs-container-header flex-between">
                        <h2 class="logs-container-header-heading">Activity Logs List Overview</h2>
                        <div class="div-logs-actions-container">
                            <div class="div-input-container">
                                <label class="label-select absolute-y-center" for="filter">
                                    <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                </label>
                                <select id="filter" class="logs-select-filter" name="filter">
                                    <option value="all">Filter All</option>
                                    <option value="signup">Filter Signup</option>
                                    <option value="login">Filter Login</option>
                                    <option value="profile">Filter Profile</option>
                                    <option value="request">Filter Request</option>
                                    <option value="response">Filter Response</option>
                                    <option value="client">Filter Client</option>
                                </select>
                            </div>
                        </div>
                    </header>
                    <div class="div-logs-list-overview-container">
                        <header class="logs-list-overview-header">
                            <p>#ID</p>
                            <p>User</p>
                            <p>Information</p>
                            <p>Timestamp</p>
                            <p>Type</p>
                        </header>
                        <div class="div-logs-list-container">
                            <?php require_once __DIR__ . '/partials/signs/none-data.php'; ?>
                            <?php require_once __DIR__ . '/partials/loaders/data-loader.php'; ?>
                            <ul class="logs-list">
                                <!-- DYNAMICALLY GENERATED TICKETS VIA AJAX -->
                            </ul>
                        </div>
                    </div>
                    <footer class="logs-container-footer flex-between">
                        <p>Applied Filter: <span class="span-applied-filter">All</span></p>
                        <p>Viewing <span class="span-total-logs">0</span> total logs.</p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/logs">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
            </div>
        </main>
    </div>

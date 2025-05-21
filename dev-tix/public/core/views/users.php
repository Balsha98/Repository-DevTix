<?php
require __DIR__ . '/partials/loaders/page-loader.php';
require __DIR__ . '/partials/modals/alert-modal.php';
require __DIR__ . '/partials/modals/logout-modal.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require __DIR__ . '/partials/sidebar.php'; ?>
            <!-- USERS CONTAINER -->
            <div class="div-users-container">
                <?php require __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-users-overview-container">
                    <header class="users-container-header flex-between">
                        <h2 class="users-container-header-heading">Users/Clients List Overview</h2>
                        <div class="div-users-actions-container">
                            <div class="div-input-container">
                                <label class="label-select absolute-y-center" for="filter">
                                    <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                </label>
                                <select id="filter" class="users-select-filter" name="filter">
                                    <option value="all">Filter All</option>
                                    <option value="1">Filter Administrator</option>
                                    <option value="2">Filter Assistant</option>
                                    <option value="3">Filter Patron</option>
                                </select>
                            </div>
                            <a class="link link-primary" href="/profile">
                                <ion-icon src="<?php echo ICON_PATH; ?>/plus.svg"></ion-icon>
                                <span>New User</span>
                            </a>
                        </div>
                    </header>
                    <div class="div-users-list-overview-container">
                        <header class="users-list-overview-header">
                            <p>#ID</p>
                            <p>User</p>
                            <p>Full Name</p>
                            <p>Email Address</p>
                            <p>Activity</p>
                        </header>
                        <div class="div-users-list-container">
                            <?php require __DIR__ . '/partials/signs/none-data.php'; ?>
                            <?php require __DIR__ . '/partials/loaders/data-loader.php'; ?>
                            <ul class="users-list">
                                <!-- DYNAMICALLY GENERATED TICKETS VIA AJAX -->
                            </ul>
                        </div>
                    </div>
                    <footer class="users-container-footer flex-between">
                        <p>Applied Filter: <span class="span-applied-filter">All</span></p>
                        <p>Viewing <span class="span-total-users">0</span> total users.</p>
                    </footer>
                </div>
            </div>
            <?php require __DIR__ . '/partials/menus/chat-menu.php'; ?>
            <!-- DIV HIDDEN INPUTS -->
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/users">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
            </div>
        </main>
    </div>

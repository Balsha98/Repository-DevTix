<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/page-loader.php';
require_once __DIR__ . '/partials/alert.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- TICKETS CONTAINER -->
            <div class="div-tickets-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-tickets-content-container">
                    <ul class="tickets-overview-list grid-4-columns">
                        <li class="tickets-overview-list-item">
                            <div class="div-overview-item-icon-container flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/paperclip.svg"></ion-icon>
                            </div>
                            <div class="div-overview-item-data-container">
                                <span class="span-overview-item">0</span>
                                <h4>Total Requests</h4>
                            </div>
                        </li>
                        <li class="tickets-overview-list-item">
                            <div class="div-overview-item-icon-container flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/check.svg"></ion-icon>
                            </div>
                            <div class="div-overview-item-data-container">
                                <span class="span-overview-item">0</span>
                                <h4>Total Resolved</h4>
                            </div>
                        </li>
                        <li class="tickets-overview-list-item">
                            <div class="div-overview-item-icon-container flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/clock.svg"></ion-icon>
                            </div>
                            <div class="div-overview-item-data-container">
                                <span class="span-overview-item">0</span>
                                <h4>Total Pending</h4>
                            </div>
                        </li>
                        <li class="tickets-overview-list-item">
                            <div class="div-overview-item-icon-container flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
                            </div>
                            <div class="div-overview-item-data-container">
                                <span class="span-overview-item">0</span>
                                <h4>Total Cancelled</h4>
                            </div>
                        </li>
                    </ul>
                    <div class="div-tickets-overview-container">
                        <header class="tickets-container-header flex-between">
                            <h2 class="tickets-container-header-heading">
                                <span class="span-client-name"><?php echo $user->getFirstName(); ?></span>'s Tickets Overview
                            </h2>
                            <div class="div-tickets-actions-container">
                                <div class="div-input-container">
                                    <label class="label-select absolute-y-center" for="filter">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                    </label>
                                    <select id="filter" class="tickets-select-filter" name="filter">
                                        <option value="all">Filter All</option>
                                        <option value="unassigned">Filter Unassigned</option>
                                        <option value="pending">Filter Pending</option>
                                        <option value="resolved">Filter Resolved</option>
                                        <option value="cancelled">Filter Cancelled</option>
                                    </select>
                                </div>
                                <a class="link link-primary" href="/ticket">
                                    <ion-icon src="<?php echo ICON_PATH; ?>/plus.svg"></ion-icon>
                                    <span>New Ticket</span>
                                </a>
                            </div>
                        </header>
                        <div class="div-tickets-list-overview-container">
                            <header class="tickets-list-overview-header">
                                <p>#ID</p>
                                <p>Patron</p>
                                <p>Subject</p>
                                <p>Assistant</p>
                                <p>Status</p>
                            </header>
                            <div class="div-tickets-list-container">
                                <?php require_once __DIR__ . '/partials/none-data.php'; ?>
                                <?php require_once __DIR__ . '/partials/data-loader.php'; ?>
                                <ul class="tickets-list">
                                    <!-- DYNAMICALLY GENERATED TICKETS VIA AJAX -->
                                </ul>
                            </div>
                        </div>
                        <footer class="tickets-container-footer flex-between">
                            <p>Applied Filter: <span class="span-applied-filter">All</span></p>
                            <p>Viewing <span class="span-total-tickets">0</span> total tickets.</p>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/tickets">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
            </div>
        </main>
    </div>

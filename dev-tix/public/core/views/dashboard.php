<?php

// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/loader.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <div class="div-dashboard-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-dashboard-content-container">
                    <?php if ($user->getRoleId() === 1) { ?>
                    <ul class="dashboard-overview-list grid-4-columns">
                        <!-- TOTAL TICKETS -->
                        <li class="dashboard-overview-list-item">
                            <header class="dashboard-overview-item-header">
                                <div class="div-overview-item-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/paperclip.svg"></ion-icon>
                                </div>
                                <div class="div-overview-item-header-data">
                                    <span>100</span>
                                    <h4>Total Requests</h4>
                                </div>
                            </header>
                            <div class="div-overview-item-link-container">
                                <a class="link link-primary flex-between" href="/tickets">
                                    <span>View Details</span>
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/plus.svg"></ion-icon>
                                </a>
                            </div>
                        </li>
                        <!-- TOTAL SOLVED TICKETS -->
                        <li class="dashboard-overview-list-item">
                            <header class="dashboard-overview-item-header">
                                <div class="div-overview-item-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/check.svg"></ion-icon>
                                </div>
                                <div class="div-overview-item-header-data">
                                    <span>80</span>
                                    <h4>Total Resolved</h4>
                                </div>
                            </header>
                            <div class="div-overview-item-link-container">
                                <a class="link link-primary flex-between" href="/tickets?status=resolved">
                                    <span>View Details</span>
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/plus.svg"></ion-icon>
                                </a>
                            </div>
                        </li>
                        <!-- TOTAL CANCELED TICKETS -->
                        <li class="dashboard-overview-list-item">
                            <header class="dashboard-overview-item-header">
                                <div class="div-overview-item-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/x.svg"></ion-icon>
                                </div>
                                <div class="div-overview-item-header-data">
                                    <span>20</span>
                                    <h4>Total Cancelled</h4>
                                </div>
                            </header>
                            <div class="div-overview-item-link-container">
                                <a class="link link-primary flex-between" href="/tickets?status=cancelled">
                                    <span>View Details</span>
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/plus.svg"></ion-icon>
                                </a>
                            </div>
                        </li>
                        <!-- TOTAL USERS -->
                        <li class="dashboard-overview-list-item">
                            <header class="dashboard-overview-item-header">
                                <div class="div-overview-item-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/users.svg"></ion-icon>
                                </div>
                                <div class="div-overview-item-header-data">
                                    <span>45</span>
                                    <h4>Total Users</h4>
                                </div>
                            </header>
                            <div class="div-overview-item-link-container">
                                <a class="link link-primary flex-between" href="/users">
                                    <span>View Details</span>
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/plus.svg"></ion-icon>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                    <div class="div-dashboard-tickets-container">
                        <header class="tickets-container-header flex-between">
                            <h2 class="tickets-container-header-heading">Tickets Overview</h2>
                            <div class="div-tickets-actions-container">
                                <div class="div-input-container">
                                    <label class="label-select absolute-y-center" for="filter">
                                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/chevron-down.svg"></ion-icon>
                                    </label>
                                    <select id="filter" name="filter">
                                        <option value="0">Select Filter</option>
                                    </select>
                                </div>
                                <a class="link link-primary" href="/ticket">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/plus.svg"></ion-icon>
                                    <span>New Ticket</span>
                                </a>
                            </div>
                        </header>
                        <div class="div-tickets-list-container">
                            <header class="tickets-list-header">
                                <p>Patron</p>
                                <p>Subject</p>
                                <p>Assistant</p>
                                <p>Status</p>
                            </header>
                            <ul class="tickets-list">
                                <!-- DYNAMICALLY GENERATED TICKETS -->
                            </ul>
                        </div>
                        <footer class="tickets-container-footer flex-between">
                            <p>Viewing <span class="span-total-tickets">&nbsp;</span> total tickets.</p>
                            <p>&copy; <?php echo date('Y'); ?> <span>DevTix Inc.</span></p>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="page" type="hidden" name="page" value="<?php echo $page; ?>">
            </div>
        </main>
    </div>

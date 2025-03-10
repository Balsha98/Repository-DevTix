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
                        <li class="dashboard-overview-list-item">
                            <!-- TOTAL TICKETS -->
                        </li>
                        <li class="dashboard-overview-list-item">
                            <!-- TOTAL SOLVED TICKETS -->
                        </li>
                        <li class="dashboard-overview-list-item">
                            <!-- TOTAL CANCELED TICKETS -->
                        </li>
                        <li class="dashboard-overview-list-item">
                            <!-- TOTAL USERS -->
                        </li>
                    </ul>
                    <?php } ?>
                    <div class="div-dashboard-tickets-container">
                        <header class="tickets-container-header flex-between">
                            <h2 class="tickets-container-header-heading">Tickets Overview</h2>
                            <div class="div-tickets-actions-container">
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

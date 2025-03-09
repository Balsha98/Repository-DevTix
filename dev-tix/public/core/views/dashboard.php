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
                    <div class="div-dashboard-requests-container">
                        
                    </div>
                </div>
            </div>
        </main>
    </div>

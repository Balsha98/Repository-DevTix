<?php
require __DIR__ . '/partials/loaders/page-loader.php';
require __DIR__ . '/partials/modals/logout-modal.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require __DIR__ . '/partials/sidebar.php'; ?>
            <!-- STATISTICS CONTAINER -->
            <div class="div-statistics-container">
                <?php require __DIR__ . '/partials/navigation.php'; ?>
                <ul class="statistics-overview-list grid-2-columns">
                    <li class="statistics-overview-list-item">
                        <div class="div-statistics-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/user.svg"></ion-icon>
                        </div>
                        <div class="div-statistics-overview-info-container">
                            <header class="statistics-overview-info-header">
                                <h4>Role Statistics</h4>
                            </header>
                            <ul class="statistics-overview-labels-list">
                                <!-- DYNAMICALLY GENERATED VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-none-chart-icon-container none-chart-role absolute-y-center hide-element">
                            <div class="div-none-chart-icon-modal absolute-center flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/pie-chart.svg"></ion-icon>
                            </div>
                        </div>
                        <div class="div-statistics-overview-chart-container absolute-y-center">
                            <canvas class="chart-canvas">&nbsp;</canvas>
                        </div>
                    </li>
                    <li class="statistics-overview-list-item">
                        <div class="div-statistics-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"></ion-icon>
                        </div>
                        <div class="div-statistics-overview-info-container">
                            <header class="statistics-overview-info-header">
                                <h4>Age Statistics</h4>
                            </header>
                            <ul class="statistics-overview-labels-list">
                                <!-- DYNAMICALLY GENERATED VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-none-chart-icon-container none-chart-age absolute-y-center hide-element">
                            <div class="div-none-chart-icon-modal absolute-center flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/pie-chart.svg"></ion-icon>
                            </div>
                        </div>
                        <div class="div-statistics-overview-chart-container absolute-y-center">
                            <canvas class="chart-canvas">&nbsp;</canvas>
                        </div>
                    </li>
                    <li class="statistics-overview-list-item">
                        <div class="div-statistics-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/zap.svg"></ion-icon>
                        </div>
                        <div class="div-statistics-overview-info-container">
                            <header class="statistics-overview-info-header">
                                <h4>Gender Statistics</h4>
                            </header>
                            <ul class="statistics-overview-labels-list">
                                <!-- DYNAMICALLY GENERATED VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-none-chart-icon-container none-chart-gender absolute-y-center hide-element">
                            <div class="div-none-chart-icon-modal absolute-center flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/pie-chart.svg"></ion-icon>
                            </div>
                        </div>
                        <div class="div-statistics-overview-chart-container absolute-y-center">
                            <canvas class="chart-canvas">&nbsp;</canvas>
                        </div>
                    </li>
                    <li class="statistics-overview-list-item">
                        <div class="div-statistics-overview-icon-container">
                            <ion-icon src="<?php echo ICON_PATH; ?>/activity.svg"></ion-icon>
                        </div>
                        <div class="div-statistics-overview-info-container">
                            <header class="statistics-overview-info-header">
                                <h4>Profession Statistics</h4>
                            </header>
                            <ul class="statistics-overview-labels-list">
                                <!-- DYNAMICALLY GENERATED VIA AJAX -->
                            </ul>
                        </div>
                        <div class="div-none-chart-icon-container none-chart-profession absolute-y-center hide-element">
                            <div class="div-none-chart-icon-modal absolute-center flex-center">
                                <ion-icon src="<?php echo ICON_PATH; ?>/pie-chart.svg"></ion-icon>
                            </div>
                        </div>
                        <div class="div-statistics-overview-chart-container absolute-y-center">
                            <canvas class="chart-canvas">&nbsp;</canvas>
                        </div>
                    </li>
                </ul>
            </div>
            <?php require __DIR__ . '/partials/menus/chat-menu.php'; ?>
            <!-- DIV HIDDEN INPUTS -->
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/statistics">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
            </div>
        </main>
    </div>

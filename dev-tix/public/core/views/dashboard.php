    <?php
    require_once __DIR__ . '/partials/loader.php';
    ?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <div class="div-dashboard-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-dashboard-content-container">
                    <?php if ((int) Session::get('role') === 1) { ?>
                    <ul class="dashboard-overview-list grid-4-columns">
                        <li class="dashboard-overview-list-item"></li>
                        <li class="dashboard-overview-list-item"></li>
                        <li class="dashboard-overview-list-item"></li>
                        <li class="dashboard-overview-list-item"></li>
                    </ul>
                    <?php } ?>
                    <div class="div-dashboard-requests-container">

                    </div>
                </div>
            </div>
        </main>
    </div>

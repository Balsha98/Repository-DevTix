<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/loaders/page-loader.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- LEAGUES CONTAINER -->
            <div class="div-leagues-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <ul class="leagues-overview-list grid-2-columns">
                    <li class="leagues-overview-list-item"></li>
                    <li class="leagues-overview-list-item"></li>
                    <li class="leagues-overview-list-item"></li>
                    <li class="leagues-overview-list-item"></li>
                </ul>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/leagues">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
            </div>
        </main>
    </div>

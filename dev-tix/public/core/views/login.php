    <?php
    require_once __DIR__ . '/partials/loaders/page-loader.php';
    require_once __DIR__ . '/partials/modals/alert-modal.php';
    ?>

    <!-- MAIN CONTAINER -->
    <main class="main-container absolute-center">
        <!-- FORM SECTION -->
        <section class="section-form">
            <header class="section-form-header">
                <h2 class="heading-secondary">Welcome to DevTix!</h2>
                <p>Please provide your <span>valid</span> credentials.</p>
            </header>
            <form class="form" action="/api/" method="POST">
                <div class="div-input-container">
                    <label class="absolute-y-center" for="username">
                        <ion-icon src="<?php echo ICON_PATH; ?>/user.svg"></ion-icon>
                    </label>
                    <input id="username" type="text" name="username" placeholder="Username" autocomplete="on" required autofocus>
                </div>
                <div class="div-input-container">
                    <label class="absolute-y-center" for="password">
                        <ion-icon src="<?php echo ICON_PATH; ?>/lock.svg"></ion-icon>
                    </label>
                    <input id="password" type="password" name="password" placeholder="Password" autocomplete="on" required>
                    <a class="link-forgot-password" href="/forgot-password">
                        Forgot your password?
                    </a>
                </div>
                <div class="div-grid-btn-container">
                    <button class="btn btn-primary btn-login">Login</button>
                </div>
                <div class="div-hidden-inputs">
                    <input id="view" type="hidden" name="view" value="views/login">
                    <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                </div>
            </form>
            <div class="div-signup-container">
                <p>Don't have an account? <a class="link-signup" href="/signup">Sign Up!</a></p>
            </div>
        </section>
        <!-- IMAGE CONTAINER -->
        <div class="div-image-container">
            <div class="overlay image-overlay">&nbsp;</div>
            <img src="<?php echo IMAGE_PATH; ?>/login-banner.jpg" alt="Image">
        </div>
    </main>

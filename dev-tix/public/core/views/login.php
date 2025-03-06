<?php
if (Session::isSet('active')) {
    Redirect::toRoute('/dashboard');
}

require_once __DIR__ . '/partials/loader.php';
require_once __DIR__ . '/partials/alert.php';
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
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                    </label>
                    <input id="username" type="text" name="username" placeholder="Username" autocomplete="on" required autofocus>
                </div>
                <div class="div-input-container">
                    <label class="absolute-y-center" for="password">
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/lock.svg"></ion-icon>
                    </label>
                    <input id="password" type="password" name="password" placeholder="Password" autocomplete="on" required>
                    <a class="link-forgot-password" href="<?php SERVER_PATH; ?>/forgot-password">
                        Forgot your password?
                    </a>
                </div>
                <div class="div-grid-btn-container">
                    <button class="btn btn-primary btn-login">Login</button>
                </div>
                <div class="div-hidden-inputs">
                    <input id="page" type="hidden" value="<?php echo $page; ?>">
                </div>
            </form>
            <div class="div-signup-container">
                <p>Don't have an account? <a class="link-signup" href="<?php echo SERVER_PATH; ?>/signup">Sign Up!</a></p>
            </div>
        </section>
        <!-- IMAGE CONTAINER -->
        <div class="div-image-container">
            <div class="overlay image-overlay">&nbsp;</div>
            <img src="<?php echo SERVER_PATH ?>/core/assets/media/images/login-banner.jpg" alt="Image">
        </div>
    </main>

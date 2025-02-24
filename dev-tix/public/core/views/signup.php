    <!-- MAIN CONTAINER -->
    <main class="main-container absolute-center">
        <!-- IMAGE CONTAINER -->
        <div class="div-image-container">
            <div class="overlay image-overlay">&nbsp;</div>
            <img src="<?php echo SERVER_PATH ?>/core/assets/media/images/signup-banner.jpg" alt="Image">
        </div>
        <!-- FORM SECTION -->
        <section class="section-form">
            <header class="section-form-header">
                <h2 class="heading-secondary">Welcome to DevTix!</h2>
                <p>Please provide your <span>valid</span> credentials.</p>
            </header>
            <form class="form" action="/api/" method="POST">
                <div class="div-multiple-inputs-grid grid-2-columns">
                    <div class="div-input-container">
                        <label class="absolute-y-center" for="first_name">
                            <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                        </label>
                        <input id="first_name" type="text" name="first_name" placeholder="First Name">
                    </div>
                    <div class="div-input-container">
                        <label class="absolute-y-center" for="last_name">
                            <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                        </label>
                        <input id="last_name" type="text" name="last_name" placeholder="Last Name">
                    </div>
                </div>
                <div class="div-input-container">
                    <label class="absolute-y-center" for="email">
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/mail.svg"></ion-icon>
                    </label>
                    <input id="email" type="email" name="email" placeholder="Email Address">
                </div>
                <div class="div-input-container">
                    <label class="absolute-y-center" for="password">
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/lock.svg"></ion-icon>
                    </label>
                    <input id="password" type="password" name="password" placeholder="Password">
                </div>
                <div class="div-grid-btn-container">
                    <button class="btn btn-primary btn-signup">Signup</button>
                </div>
                <div class="div-hidden-inputs">
                    <input id="page" type="hidden" value="<?php echo $page; ?>">
                </div>
            </form>
            <div class="div-login-container">
                <p>Already have an account? <a class="link-login" href="<?php echo SERVER_PATH; ?>/login">Log In!</a></p>
            </div>
        </section>
    </main>

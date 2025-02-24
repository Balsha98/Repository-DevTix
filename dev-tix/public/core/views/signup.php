    <?php require_once __DIR__ . '/partials/alert.php'; ?>

    <!-- MAIN CONTAINER -->
    <main class="main-container absolute-center">
        <!-- STEP INDICATORS CONTAINER -->
        <div class="div-step-indicators-container">
            <header class="step-indicators-header grid-2-columns">
                <div class="div-step-indicator active-step-indicator" data-step="1">
                    <p>Personal Information</p>
                </div>
                <div class="div-step-indicator" data-step="2">
                    <p>Account Information</p>
                </div>
            </header>
            <div class="div-step-progress-bar">
                <div class="div-progress">&nbsp;</div>
                <ul class="circle-indicator-list">
                    <li class="circle-indicator-list-item flex-center absolute-y-center left-circle-indicator-list-item">
                        <span class="span-circle-indicator active-span-indicator" data-step="1">&nbsp;</span>
                    </li>
                    <li class="circle-indicator-list-item flex-center absolute-y-center middle-circle-indicator-list-item">
                        <span class="span-circle-indicator" data-step="2">&nbsp;</span>
                    </li>
                    <li class="circle-indicator-list-item flex-center absolute-y-center right-circle-indicator-list-item">
                        <span class="span-circle-indicator" data-step="3">&nbsp;</span>
                    </li>
                </ul>
            </div>
        </div>
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
                <div class="div-signup-step-container" data-step="1">
                    <div class="div-multiple-inputs-grid grid-2-columns">
                        <div class="div-input-container required-container">
                            <label class="absolute-y-center" for="first_name">
                                <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                            </label>
                            <input id="first_name" type="text" name="first_name" placeholder="First Name" autofocus>
                        </div>
                        <div class="div-input-container required-container">
                            <label class="absolute-y-center" for="last_name">
                                <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                            </label>
                            <input id="last_name" type="text" name="last_name" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="div-input-container required-container">
                        <label class="absolute-y-center" for="email">
                            <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/mail.svg"></ion-icon>
                        </label>
                        <input id="email" type="email" name="email" placeholder="Email Address">
                    </div>
                    <div class="div-multiple-inputs-grid grid-2-columns">
                        <div class="div-input-container">
                            <label class="absolute-y-center" for="age">
                                <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/bar-chart-2.svg"></ion-icon>
                            </label>
                            <input id="age" type="number" name="age" min="0" placeholder="Age">
                        </div>
                        <div class="div-input-container">
                            <label class="label-select absolute-y-center" for="gender">
                                <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/chevron-down.svg"></ion-icon>
                            </label>
                            <select id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="div-grid-btn-container">
                        <button class="btn btn-primary btn-step" type="button" data-step="2">
                            Next
                        </button>
                    </div>
                </div>
                <div class="div-signup-step-container hide-element" data-step="2">
                    <div class="div-input-container required-container">
                        <label class="absolute-y-center" for="username">
                            <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                        </label>
                        <input id="username" type="text" name="username" placeholder="Username">
                    </div>
                    <div class="div-input-container">
                        <label class="label-select absolute-y-center" for="role">
                            <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/chevron-down.svg"></ion-icon>
                        </label>
                        <select id="role" name="role">
                            <option value="">Select Role</option>
                            <option value="2">Assistant</option>
                            <option value="3">Patron</option>
                        </select>
                    </div>
                    <div class="div-input-container required-container">
                        <label class="absolute-y-center" for="password">
                            <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/mail.svg"></ion-icon>
                        </label>
                        <input id="password" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="div-grid-btn-container grid-2-columns">
                        <button class="btn btn-outline-primary btn-step" type="button" data-step="1">
                            Previous
                        </button>
                        <button class="btn btn-primary btn-signup" type="submit">
                            Signup
                        </button>
                    </div>
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

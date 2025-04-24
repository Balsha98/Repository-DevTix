    <?php
    require_once __DIR__ . '/partials/loaders/page-loader.php';
    require_once __DIR__ . '/partials/modals/alert-modal.php';
    require_once __DIR__ . '/partials/modals/logout-modal.php';
    ?>

    <!-- PAGE HEADER -->
    <header class="page-header">
        <div class="centered-container">
            <div class="flex-between">
                <div class="div-logo-container">
                    <ion-icon src="<?php echo ICON_PATH; ?>/page-logo.svg"></ion-icon>
                    <h2>DevTix</h2>
                </div>
                <nav class="header-navigation">
                    <ul class="nav-list">
                        <li class="nav-list-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-list-item">
                            <a class="nav-link" href="#how-it-works">How It Works</a>
                        </li>
                        <li class="nav-list-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-list-item">
                            <a class="nav-link" href="#testimonials">Testimonials</a>
                        </li>
                    </ul>
                </nav>
                <div class="dropdown-container dropdown-account">
                    <button class="btn btn-dropdown">Account</button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <?php if (Session::isSet('active')) { ?>
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/dashboard">Dashboard</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <button class="dropdown-btn btn-welcome-logout">Logout</button>
                            </li>
                        </ul>
                        <?php } else { ?>
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/login" target="_blank">Login</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/signup" target="_blank">Signup</a>
                            </li>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="hero" class="section-hero">
        <div class="overlay hero-overlay">&nbsp;</div>
        <div class="centered-container">
            <div class="div-hero-content-container hide-hero-content">
                <header class="hero-content-header">
                    <h1 class="heading-primary">
                        There's no issue we cannot solve. Post a new request in seconds.
                    </h1>
                    <p>
                        At <span>DevTix</span> our customers are our #1 priority. We want to make sure
                        that everybody is heard, one way or the other. You've encountered some unresolvable
                        issues? Open an account as of TODAY!
                    </p>
                </header>
                <div class="div-grid-btn-container grid-2-columns">
                    <?php if (Session::isSet('active')) { ?>
                    <a class="link link-primary" href="/dashboard">Dashboard</a>
                    <?php } else { ?>
                    <a class="link link-primary" href="/signup" target="_blank">Signup</a>
                    <?php } ?>
                    <a class="link link-outline-primary" href="#about">Get Started</a>
                </div>
                <div class="div-hero-data-container">
                    <ul class="hero-users-list">
                        <li class="hero-users-list-item">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-1.jpg" alt="User Image">
                        </li>
                        <li class="hero-users-list-item">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-2.jpg" alt="User Image">
                        </li>
                        <li class="hero-users-list-item">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-3.jpg" alt="User Image">
                        </li>
                        <li class="hero-users-list-item">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-4.jpg" alt="User Image">
                        </li>
                        <li class="hero-users-list-item">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-5.jpg" alt="User Image">
                        </li>
                    </ul>
                    <p class="hero-data-description">
                        <span>100,000+</span> users, and counting!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="section-content section-about hide-section">
        <div class="centered-container">
            <div class="section-container">
                <header class="section-header">
                    <span class="section-subheading primary-subheading">About</span>
                    <h2 class="section-heading">Who are we, and what do we care about?</h2>
                </header>
                <ul class="about-list">
                    <li class="about-list-item grid-2-columns">
                        <div class="div-about-content-container left-about-content-container">
                            <h4 class="about-heading">Customers Are Our #1 Priority</h4>
                            <p class="about-description">
                                Since this is the about section of the website we will have to write some placeholder text to replace the dummy text
                                that was initially placed there; having dummy text like that makes for a worse looking website, it just showcases gives
                                off the wrong vibe. We will replace this text for each one of the sections, where one section will have more text and the
                                other one will have less.
                            </p>
                        </div>
                        <div class="div-image-container about-image-container right-about-image">
                            <img src="<?php echo IMAGE_PATH; ?>/handshake.jpg" alt="About Image">
                        </div>
                    </li>
                    <li class="about-list-item grid-2-columns">
                        <div class="div-image-container about-image-container left-about-image">
                            <img src="<?php echo IMAGE_PATH; ?>/customer-support.jpg" alt="About Image">
                        </div>
                        <div class="div-about-content-container right-about-content-container">
                            <h4 class="about-heading">We Resolve Your Requests</h4>
                            <p class="about-description">
                                Since this is the about section of the website we will have to write some placeholder text to replace the dummy text
                                that was initially placed there; having dummy text like that makes for a worse looking website, it just showcases gives
                                off the wrong vibe. We will replace this text for each one of the sections, where one section will have more text and the
                                other one will have less.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    
    <!-- HOT IT WORKS SECTION -->
    <section id="how-it-works" class="section-content section-how-it-works hide-section">
        <div class="centered-container">
            <div class="section-container">
                <header class="section-header">
                    <span class="section-subheading white-subheading">How It Works</span>
                    <h2 class="section-heading">How to get started with our platform?</h2>
                </header>
                <ul class="steps-list">
                    <li class="steps-list-item grid-2-columns">
                        <div class="div-steps-content-container">
                            <header class="steps-content-header">
                                <span class="span-steps-counter">01</span>
                                <h2 class="steps-heading">Create Your DevTix Account</h2>
                            </header>
                            <p class="steps-description">
                                Since this is the steps section of the website we will have to write some placeholder text to replace the dummy text
                                that was initially placed there; having dummy text like that makes for a worse looking website, it just showcases gives
                                off the wrong vibe. We will replace this text for each one of the sections.
                            </p>
                        </div>
                        <div class="div-image-container steps-image-container right-steps-image">
                            <img src="<?php echo IMAGE_PATH; ?>/signup-example.png" alt="How It Works Image">
                        </div>
                    </li>
                    <li class="steps-list-item grid-2-columns">
                        <div class="div-image-container steps-image-container left-steps-image">
                            <img src="<?php echo IMAGE_PATH; ?>/post-ticket-example.png" alt="How It Works">
                        </div>
                        <div class="div-steps-content-container">
                            <header class="steps-content-header">
                                <span class="span-steps-counter">02</span>
                                <h2 class="steps-heading">Post Your Request</h2>
                            </header>
                            <p class="steps-description">
                                Since this is the steps section of the website we will have to write some placeholder text to replace the dummy text
                                that was initially placed there; having dummy text like that makes for a worse looking website, it just showcases gives
                                off the wrong vibe. We will replace this text for each one of the sections.
                            </p>
                        </div>
                    </li>
                    <li class="steps-list-item grid-2-columns">
                        <div class="div-steps-content-container">
                            <header class="steps-content-header">
                                <span class="span-steps-counter">03</span>
                                <h2 class="steps-heading">Wait For An Assistant</h2>
                            </header>
                            <p class="steps-description">
                                Since this is the steps section of the website we will have to write some placeholder text to replace the dummy text
                                that was initially placed there; having dummy text like that makes for a worse looking website, it just showcases gives
                                off the wrong vibe. We will replace this text for each one of the sections.
                            </p>
                        </div>
                        <div class="div-image-container steps-image-container right-steps-image">
                            <img src="<?php echo IMAGE_PATH; ?>/claim-ticket-example.png" alt="How It Works Image">
                        </div>
                    </li>
                    <li class="steps-list-item grid-2-columns">
                        <div class="div-image-container steps-image-container left-steps-image">
                            <img src="<?php echo IMAGE_PATH; ?>/response-ticket-example.png" alt="How It Works Image">
                        </div>
                        <div class="div-steps-content-container">
                            <header class="steps-content-header">
                                <span class="span-steps-counter">04</span>
                                <h2 class="steps-heading">Work Towards The Solution</h2>
                            </header>
                            <p class="steps-description">
                                Since this is the steps section of the website we will have to write some placeholder text to replace the dummy text
                                that was initially placed there; having dummy text like that makes for a worse looking website, it just showcases gives
                                off the wrong vibe. We will replace this text for each one of the sections.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section id="features" class="section-content section-features hide-section">
        <div class="centered-container">
            <div class="section-container">
                <header class="section-header">
                    <span class="section-subheading primary-subheading">Features</span>
                    <h2 class="section-heading">What are some features that stand out?</h2>
                </header>
                <ul class="features-list grid-4-columns">
                    <li class="features-list-item">
                        <div class="div-features-icon-container flex-center">
                            <ion-icon src="<?php echo ICON_PATH; ?>/activity.svg"></ion-icon>
                        </div>
                        <div class="div-features-content-container">
                            <h4 class="features-heading">An Active Community</h4>
                            <p class="features-description">
                                Now these are the features container, and these will container a bit less text, just so we do not overflow the container's
                                width; should work well enough in the end!
                            </p>
                        </div>
                    </li>
                    <li class="features-list-item">
                        <div class="div-features-icon-container flex-center">
                            <ion-icon src="<?php echo ICON_PATH; ?>/headphones.svg"></ion-icon>
                        </div>
                        <div class="div-features-content-container">
                            <h4 class="features-heading">Focus On What Matters</h4>
                            <p class="features-description">
                                Now these are the features container, and these will container a bit less text, just so we do not overflow the container's
                                width; should work well enough in the end!
                            </p>
                        </div>
                    </li>
                    <li class="features-list-item">
                        <div class="div-features-icon-container flex-center">
                            <ion-icon src="<?php echo ICON_PATH; ?>/wind.svg"></ion-icon>
                        </div>
                        <div class="div-features-content-container">
                            <h4 class="features-heading">Response In Seconds</h4>
                            <p class="features-description">
                                Now these are the features container, and these will container a bit less text, just so we do not overflow the container's
                                width; should work well enough in the end!
                            </p>
                        </div>
                    </li>
                    <li class="features-list-item">
                        <div class="div-features-icon-container flex-center">
                            <ion-icon src="<?php echo ICON_PATH; ?>/feather.svg"></ion-icon>
                        </div>
                        <div class="div-features-content-container">
                            <h4 class="features-heading">Leave Your Mark</h4>
                            <p class="features-description">
                                Now these are the features container, and these will container a bit less text, just so we do not overflow the container's
                                width; should work well enough in the end!
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section id="testimonials" class="section-content section-testimonials hide-section">
        <div class="centered-container">
            <div class="section-container">
                <header class="section-header">
                    <span class="section-subheading white-subheading">Testimonials</span>
                    <h2 class="section-heading">What our customers think of us?</h2>
                </header>
                <ul class="testimonials-list">
                    <li class="testimonials-list-item active-testimonial" data-testimonial-id="1">
                        <div class="div-image-container testimonials-image-container">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-1.jpg" alt="User Image">
                        </div>
                        <div class="div-testimonials-data-container">
                            <h4 class="testimonials-heading">Easy to use. They got my support!</h4>
                            <blockquote class="testimonials-quote">
                                Wow, I really enjoyed using this application; definitely going up on my list of recommendations. No hassle, easy to
                                us, and very well organized... I am for sure getting all of my friends on this wave before it's too late... Let's get it!
                            </blockquote>
                            <div class="div-testimonials-author-container">
                                <p>Jenna Storm</p>
                                <span>Cleveland, OH</span>
                            </div>
                        </div>
                    </li>
                    <li class="testimonials-list-item" data-testimonial-id="2">
                        <div class="div-image-container testimonials-image-container">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-2.jpg" alt="User Image">
                        </div>
                        <div class="div-testimonials-data-container">
                            <h4 class="testimonials-heading">Kudos to the customer support!</h4>
                            <blockquote class="testimonials-quote">
                                Wow, I really enjoyed using this application; definitely going up on my list of recommendations. No hassle, easy to
                                us, and very well organized... I am for sure getting all of my friends on this wave before it's too late... Let's get it!
                            </blockquote>
                            <div class="div-testimonials-author-container">
                                <p>John Davis</p>
                                <span>San Diego, CA</span>
                            </div>
                        </div>
                    </li>
                    <li class="testimonials-list-item" data-testimonial-id="3">
                        <div class="div-image-container testimonials-image-container">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-3.jpg" alt="User Image">
                        </div>
                        <div class="div-testimonials-data-container">
                            <h4 class="testimonials-heading">Money well spent after all!</h4>
                            <blockquote class="testimonials-quote">
                                Wow, I really enjoyed using this application; definitely going up on my list of recommendations. No hassle, easy to
                                us, and very well organized... I am for sure getting all of my friends on this wave before it's too late... Let's get it!
                            </blockquote>
                            <div class="div-testimonials-author-container">
                                <p>Sarah Michaels</p>
                                <span>Dallas, TX</span>
                            </div>
                        </div>
                    </li>
                    <li class="testimonials-list-item" data-testimonial-id="4">
                        <div class="div-image-container testimonials-image-container">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-4.jpg" alt="User Image">
                        </div>
                        <div class="div-testimonials-data-container">
                            <h4 class="testimonials-heading">An overall great community!</h4>
                            <blockquote class="testimonials-quote">
                                Wow, I really enjoyed using this application; definitely going up on my list of recommendations. No hassle, easy to
                                us, and very well organized... I am for sure getting all of my friends on this wave before it's too late... Let's get it!
                            </blockquote>
                            <div class="div-testimonials-author-container">
                                <p>Steven Patrick</p>
                                <span>Seattle, WA</span>
                            </div>
                        </div>
                    </li>
                    <li class="testimonials-list-item" data-testimonial-id="5">
                        <div class="div-image-container testimonials-image-container">
                            <img src="<?php echo IMAGE_PATH; ?>/hero-user-5.jpg" alt="User Image">
                        </div>
                        <div class="div-testimonials-data-container">
                            <h4 class="testimonials-heading">Get yourself an account; it's worth it!</h4>
                            <blockquote class="testimonials-quote">
                                Wow, I really enjoyed using this application; definitely going up on my list of recommendations. No hassle, easy to
                                us, and very well organized... I am for sure getting all of my friends on this wave before it's too late... Let's get it!
                            </blockquote>
                            <div class="div-testimonials-author-container">
                                <p>Yu Chen</p>
                                <span>NYC, NY</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="div-testimonials-controls-container">
                    <button class="btn btn-white flex-center btn-testimonials-step" data-direction="prev">
                        <ion-icon src="<?php echo ICON_PATH; ?>/chevron-left.svg"></ion-icon>
                    </button>
                    <ul class="indicators-list">
                        <li class="indicators-list-item" data-testimonial-id="1">
                            <span class="span-indicator active-span-indicator">&nbsp;</span>
                        </li>
                        <li class="indicators-list-item" data-testimonial-id="2">
                            <span class="span-indicator">&nbsp;</span>
                        </li>
                        <li class="indicators-list-item" data-testimonial-id="3">
                            <span class="span-indicator">&nbsp;</span>
                        </li>
                        <li class="indicators-list-item" data-testimonial-id="4">
                            <span class="span-indicator">&nbsp;</span>
                        </li>
                        <li class="indicators-list-item" data-testimonial-id="5">
                            <span class="span-indicator">&nbsp;</span>
                        </li>
                    </ul>
                    <button class="btn btn-white flex-center btn-testimonials-step" data-direction="next">
                        <ion-icon src="<?php echo ICON_PATH; ?>/chevron-right.svg"></ion-icon>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- BACK TO TOP BUTTON -->
    <div class="div-to-top-btn-container hide-to-top-btn">
        <button class="btn btn-icon btn-to-top">
            <ion-icon src="<?php echo ICON_PATH; ?>/chevron-up.svg"></ion-icon>
        </button>
    </div>

    <!-- PAGE FOOTER -->
    <footer class="page-footer">
        <div class="centered-container">
            <div class="div-footer-content-container grid-4-columns">
                <header class="footer-content-container-header grid-span-across-all">
                    <div class="div-logo-container">
                        <ion-icon src="<?php echo ICON_PATH; ?>/page-logo.svg"></ion-icon>
                        <h2>DevTix</h2>
                    </div>
                    <?php if (Session::isSet('active')) { ?>
                    <a class="link link-primary" href="/dashboard">Dashboard</a>
                    <?php } else { ?>
                    <a class="link link-primary" href="/signup" target="_blank">Become a Member</a>
                    <?php } ?>
                </header>
                <div class="div-footer-content">
                    <h2 class="footer-content-heading">Follow Us</h2>
                    <ul class="socials-list">
                        <li class="socials-list-item flex-center">
                            <a class="socials-link flex-center" href="https://www.facebook.com/" target="_blank">
                                <ion-icon src="<?php echo ICON_PATH; ?>/facebook.svg"></ion-icon>
                            </a>
                        </li>
                        <li class="socials-list-item flex-center">
                            <a class="socials-link flex-center" href="https://www.instagram.com/" target="_blank">
                                <ion-icon src="<?php echo ICON_PATH; ?>/instagram.svg"></ion-icon>
                            </a>
                        </li>
                        <li class="socials-list-item flex-center">
                            <a class="socials-link flex-center" href="https://x.com/" target="_blank">
                                <ion-icon src="<?php echo ICON_PATH; ?>/twitter.svg"></ion-icon>
                            </a>
                        </li>
                        <li class="socials-list-item flex-center">
                            <a class="socials-link flex-center" href="https://www.linkedin.com/" target="_blank">
                                <ion-icon src="<?php echo ICON_PATH; ?>/linkedin.svg"></ion-icon>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="div-footer-content">
                    <h2 class="footer-content-heading">Company Notice</h2>
                    <ul class="footer-links-list">
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/external-link.svg"></ion-icon>
                            <p class="footer-content-description">Privacy Policy</p>
                        </li>
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/external-link.svg"></ion-icon>
                            <p class="footer-content-description">Terms & Conditions</p>
                        </li>
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/external-link.svg"></ion-icon>
                            <p class="footer-content-description">User Agreement</p>
                        </li>
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/external-link.svg"></ion-icon>
                            <p class="footer-content-description">Services</p>
                        </li>
                    </ul>
                </div>
                <div class="div-footer-content">
                    <h2 class="footer-content-heading">Contact Us</h2>
                    <ul class="footer-links-list">
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/map-pin.svg"></ion-icon>
                            <p class="footer-content-description">Dubrovnik, Croatia</p>
                        </li>
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/mail.svg"></ion-icon>
                            <p class="footer-content-description">support@devtix.hr</p>
                        </li>
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/phone.svg"></ion-icon>
                            <p class="footer-content-description">+385 99 123 4567</p>
                        </li>
                        <li class="footer-links-list-item">
                            <ion-icon src="<?php echo ICON_PATH; ?>/home.svg"></ion-icon>
                            <p class="footer-content-description">+385 20 433 000</p>
                        </li>
                    </ul>
                </div>
                <div class="div-footer-content">
                    <h2 class="footer-content-heading">Newsletter</h2>
                    <div class="div-newsletter-form-container">
                        <p class="footer-content-description">Wish to receive the <span>latest</span> updates?</p>
                        <form class="form newsletter-form" action="/api/" method="POST">
                            <div class="div-input-container">
                                <label class="absolute-y-center" for="email">
                                    <ion-icon src="<?php echo ICON_PATH; ?>/mail.svg"></ion-icon>
                                </label>
                                <input 
                                    id="email" type="email" name="email" 
                                    placeholder="Email Address" autocomplete="on" required
                                >
                            </div>
                            <button class="btn btn-primary btn-newsletter">Yes!</button>
                            <div class="div-hidden-inputs">
                                <input id="view" type="hidden" name="route" value="views/welcome">
                                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="div-copyright-container">
                <p>&copy; <?php echo date('Y'); ?> <span>DevTix Inc.</span></p>
                <p>Designed by RIT Croatia students.</p>
            </div>
        </div>
    </footer>

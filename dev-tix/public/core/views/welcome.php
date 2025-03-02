    <!-- PAGE HEADER -->
    <header class="page-header ">
        <div class="centered-container">
            <div class="flex-between">
                <div class="div-logo-container">
                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/images/page-logo.svg"></ion-icon>
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
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a 
                                    class="dropdown-link" 
                                    href="<?php echo SERVER_PATH; ?>/login" 
                                    target="_blank"
                                >
                                    Login
                                </a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a 
                                    class="dropdown-link" 
                                    href="<?php echo SERVER_PATH; ?>/signup" 
                                    target="_blank"
                                >
                                    Signup
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="section-hero">
        <div class="overlay hero-overlay">&nbsp;</div>
        <div class="div-hero-content-container hide-hero-content">
            <header class="hero-content-header">
                <h1 class="heading-primary">
                    There's no issue we cannot solve. Post a new request in seconds.
                </h1>
                <p>
                    At <span>DevTix</span> our customers are our #1 priority. We want to make sure
                    that everybody is heard, one way or the other. You've encountered some unresorvalbe
                    issues? Open an account as of TODAY!
                </p>
            </header>
            <div class="div-grid-btn-container grid-2-columns">
                <a 
                    class="link link-primary"
                    href="<?php echo SERVER_PATH; ?>/signup" 
                    target="_blank"
                >
                    Signup
                </a>
                <a 
                    class="link link-outline-primary"
                    href="#about"
                >
                    Get Started
                </a>
            </div>
            <div class="div-hero-data-container">
                <ul class="hero-users-list">
                    <li class="hero-users-list-item">
                        <img 
                            src="<?php echo SERVER_PATH; ?>/core/assets/media/images/hero-user-1.jpg" 
                            alt="User Image"
                        >
                    </li>
                    <li class="hero-users-list-item">
                        <img 
                            src="<?php echo SERVER_PATH; ?>/core/assets/media/images/hero-user-2.jpg" 
                            alt="User Image"
                        >
                    </li>
                    <li class="hero-users-list-item">
                        <img 
                            src="<?php echo SERVER_PATH; ?>/core/assets/media/images/hero-user-3.jpg" 
                            alt="User Image"
                        >
                    </li>
                    <li class="hero-users-list-item">
                        <img 
                            src="<?php echo SERVER_PATH; ?>/core/assets/media/images/hero-user-4.jpg" 
                            alt="User Image"
                        >
                    </li>
                    <li class="hero-users-list-item">
                        <img 
                            src="<?php echo SERVER_PATH; ?>/core/assets/media/images/hero-user-5.jpg" 
                            alt="User Image"
                        >
                    </li>
                </ul>
                <p class="hero-data-description">
                    <span>100,000+</span> users, and counting!
                </p>
            </div>
        </div>
    </section>

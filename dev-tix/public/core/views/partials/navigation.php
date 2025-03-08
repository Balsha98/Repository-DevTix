    <!-- NAVIGATION -->
    <div class="div-navigation-container">
        <h2 class="navigation-heading">
            <span class="span-welcome-message">&nbsp;</span>, User!
        </h2>
        <nav class="dashboard-navigation">
            <ul class="dashboard-nav-list">
                <li class="dropdown-container dropdown-notifications">
                    <button class="btn btn-icon btn-nav-icon flex-center">
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/bell.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/login">Login</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/signup">Signup</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="dropdown-container dropdown-user">
                    <button class="btn btn-icon btn-nav-icon flex-center">
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/user.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/profile">Profile</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <!-- SIDEBAR -->
    <div class="div-sidebar-container">
        <!-- EXPANDED SIDEBAR -->
        <div class="sidebar-container-expand collapse-sidebar">
            <header class="sidebar-header">
                <div class="div-logo-container dashboard-logo-container">
                    <ion-icon src="<?php echo ICON_PATH; ?>/page-logo.svg"></ion-icon>
                    <h2>DevTix</h2>
                </div>
                <button class="btn btn-icon btn-sidebar-menu btn-sidebar-menu-close">
                    <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart.svg"></ion-icon>
                </button>
            </header>
            <nav class="sidebar-navigation">
                <ul class="sidebar-nav-list sidebar-nav-list-expand">
                    <li class="sidebar-nav-list-item list-item-general">
                        <header class="sidebar-nav-list-item-header">
                            <h4 class="sidebar-nav-heading">General</h4>
                            <button class="btn btn-icon btn-sidebar-dropdown">
                                <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                            </button>
                        </header>
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'dashboard' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/dashboard"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/grid.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'tickets' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/tickets"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/paperclip.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Ticket Requests</span>
                                </a>
                            </li>
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'profile' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/profile/<?php echo $user->getViewAsUserId(); ?>"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/user.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Profile</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-list-item list-item-interactive">
                        <header class="sidebar-nav-list-item-header">
                            <h4 class="sidebar-nav-heading">Interactive</h4>
                            <button class="btn btn-icon btn-sidebar-dropdown">
                                <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                            </button>
                        </header>
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'leagues' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/leagues"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/award.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Leagues</span>
                                </a>
                            </li>
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'leaderboard' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/leaderboard"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Leaderboard</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-list-item list-item-accessories">
                        <header class="sidebar-nav-list-item-header">
                            <h4 class="sidebar-nav-heading">Accessories</h4>
                            <button class="btn btn-icon btn-sidebar-dropdown">
                                <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                            </button>
                        </header>
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'notifications' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/notifications"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/bell.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Notifications</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($user->getRoleId() === 1) { ?>
                    <li class="sidebar-nav-list-item list-item-administrator">
                        <header class="sidebar-nav-list-item-header">
                            <h4 class="sidebar-nav-heading">Administrator</h4>
                            <button class="btn btn-icon btn-sidebar-dropdown">
                                <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                            </button>
                        </header>
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'users' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/users"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/users.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Users</span>
                                </a>
                            </li>
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'statistics' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/statistics"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/pie-chart.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Statistics</span>
                                </a>
                            </li>
                            <li class="sidebar-links-list-item">
                                <a 
                                    class="sidebar-link sidebar-link-expand <?php echo $page === 'statistics' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/logs"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/list.svg"
                                    ></ion-icon>
                                    <span class="span-sidebar-link-name">Logs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
            <footer class="sidebar-footer">
                <div class="div-sidebar-user-content-container">
                    <div class="div-sidebar-user-info-container">
                        <?php echo Image::renderListItemUserImage($user, 'sidebar'); ?>
                        <div class="div-sidebar-user-description-container">
                            <p class="text-username">
                                <?php echo $user->getFullName(); ?>
                            </p>
                            <span class="text-role-name">
                                <?php echo $user->getRoleName(); ?>
                            </span>
                        </div>
                    </div>
                    <button class="btn btn-icon btn-sidebar-logout flex-center">
                        <ion-icon src="<?php echo ICON_PATH; ?>/log-out.svg"></ion-icon>
                    </button>
                </div>
            </footer>
        </div>
        <!-- COLLAPSED SIDEBAR -->
        <div class="sidebar-container-collapse">
            <header class="sidebar-header flex-center">
                <button class="btn btn-icon btn-sidebar-menu btn-sidebar-menu-open">
                    <ion-icon src="<?php echo ICON_PATH; ?>/menu.svg"></ion-icon>
                </button>
            </header>
            <nav class="sidebar-navigation">
                <ul class="sidebar-nav-list sidebar-nav-list-collapse">
                    <li class="sidebar-nav-list-item sidebar-nav-list-item-collapse">
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'dashboard' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/dashboard"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/grid.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Dashboard</p>
                                </div>
                            </li>
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'tickets' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/tickets"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/paperclip.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Tickets</p>
                                </div>
                            </li>
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'profile' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/profile/<?php echo $user->getViewAsUserId(); ?>"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/user.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Profile</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-list-item sidebar-nav-list-item-collapse">
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'leagues' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/leagues"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/award.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Leagues</p>
                                </div>
                            </li>
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'leaderboard' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/leaderboard"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Leaderboard</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-list-item sidebar-nav-list-item-collapse">
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'notifications' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/notifications"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/bell.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Notifications</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <?php if ($user->getRoleId() === 1) { ?>
                    <li class="sidebar-nav-list-item sidebar-nav-list-item-collapse">
                        <ul class="sidebar-links-list">
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'users' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/users"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/users.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Users</p>
                                </div>
                            </li>
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'statistics' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/statistics"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/pie-chart.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Statistics</p>
                                </div>
                            </li>
                            <li class="sidebar-links-list-item flex-center">
                                <a 
                                    class="sidebar-link sidebar-link-collapse <?php echo $page === 'logs' ? 'active-sidebar-link' : ''; ?>" 
                                    href="/logs"
                                >
                                    <ion-icon 
                                        class="sidebar-link-icon" 
                                        src="<?php echo ICON_PATH; ?>/list.svg"
                                    ></ion-icon>
                                </a>
                                <div class="div-sidebar-link-name-container-collapse">
                                    <span class="span-sidebar-link-indicator-collapse">&nbsp;</span>
                                    <p class="text-sidebar-link-name-collapse">Logs</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
            <footer class="sidebar-footer flex-center">
                <?php echo Image::renderListItemUserImage($user, 'sidebar'); ?>
            </footer>
        </div>
    </div>

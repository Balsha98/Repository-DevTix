    <!-- NAVIGATION -->
    <div class="div-navigation-container">
        <h2 class="navigation-heading">
            <span class="span-welcome-message">&nbsp;</span>, <?php echo $user->getFirstName(); ?>!
        </h2>
        <nav class="dashboard-navigation">
            <ul class="dashboard-nav-list">
                <?php if ($user->getRoleId() === 1) { ?>
                <li class="dropdown-container dropdown-clients">
                    <button class="btn btn-icon btn-nav-icon">
                        <ion-icon src="<?php echo ICON_PATH; ?>/users.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <header class="clients-menu-header flex-between">
                            <h4><span class="span-total-clients">0</span> total clients.</h4>
                            <form class="form" action="/api/" method="PUT">
                                <button class="btn btn-primary btn-revert">Revert</button>
                            </form>
                        </header>
                        <ul class="dropdown-menu-list clients-menu-list">
                            <!-- DYNAMICALLY GENERATED VIA AJAX -->
                        </ul>
                        <footer class="clients-menu-footer">
                            <a class="link link-primary flex-between" href="/users">
                                <span>View Clients</span>
                                <ion-icon src="<?php echo ICON_PATH; ?>/external-link.svg"></ion-icon>
                            </a>
                        </footer>
                    </div>
                </li>
                <?php } ?>
                <li class="dropdown-container dropdown-notifications">
                    <span class="span-notifications-indicator">&nbsp;</span>
                    <button class="btn btn-icon btn-nav-icon">
                        <ion-icon src="<?php echo ICON_PATH; ?>/bell.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <header class="notifications-menu-header flex-between">
                            <h4><span class="span-total-unread">0</span> unread notifications.</h4>
                            <form class="form" action="/api/" method="PUT">
                                <button class="btn btn-primary btn-mark-as-read">Mark As Read</button>
                                <div class="div-hidden-inputs">
                                    <input id="is_read" type="hidden" name="is_read" value="1">
                                </div>
                            </form>
                        </header>
                        <div class="div-notifications-menu-list-container">
                            <?php require_once __DIR__ . '/signs/none-notifications.php'; ?>
                            <ul class="dropdown-menu-list notifications-menu-list">
                                <!-- DYNAMICALLY GENERATED VIA AJAX -->
                            </ul>
                        </div>
                        <footer class="notifications-menu-footer">
                            <a class="link link-primary flex-between" href="/notifications">
                                <span>View Notifications</span>
                                <ion-icon src="<?php echo ICON_PATH; ?>/external-link.svg"></ion-icon>
                            </a>
                        </footer>
                    </div>
                </li>
                <li class="dropdown-container dropdown-user">
                    <button class="btn btn-icon btn-nav-icon">
                        <ion-icon src="<?php echo ICON_PATH; ?>/user.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/profile/<?php echo $user->getId(); ?>">Profile</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php if ($user->getRoleId() === 1) { ?>
                <li class="dropdown-container dropdown-settings">
                    <button class="btn btn-icon btn-nav-icon">
                        <ion-icon src="<?php echo ICON_PATH; ?>/settings.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu hide-dropdown">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <ul class="dropdown-menu-list">
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/users">Users</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/statistics">Statistics</a>
                            </li>
                            <li class="dropdown-menu-list-item">
                                <a class="dropdown-link" href="/logs">Logs</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <div class="div-hidden-inputs">
            <input id="partial" type="hidden" name="partial" value="partials/navigation">
            <input id="view_as_user_id" type="hidden" name="view_as_user_id" value="<?php echo $user->getViewAsUserId(); ?>">
        </div>
    </div>

    <!-- NAVIGATION -->
    <div class="div-navigation-container">
        <h2 class="navigation-heading">
            <span class="span-welcome-message">&nbsp;</span>, <?php echo $user->getFirstName(); ?>!
        </h2>
        <nav class="dashboard-navigation">
            <?php
            $isAdmin = $user->getRoleId() === 1;
            $notifications = Session::getDbInstance()->executeQuery(
                'SELECT * FROM notifications' . ($isAdmin ? ';' : " WHERE user_id = {$user->getId()};"),
            )->getQueryResult();

            $unreadNotifications = Session::getDbInstance()->executeQuery(
                'SELECT COUNT(notification_id) as total FROM notifications WHERE is_read = 0;',
            )->getQueryResult()['total'];
            ?>
            <ul class="dashboard-nav-list">
                <li class="dropdown-container dropdown-notifications">
                    <?php if ($unreadNotifications > 0) { ?>
                    <span class="span-notifications-indicator">&nbsp;</span>
                    <?php } ?>
                    <button class="btn btn-icon btn-nav-icon">
                        <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/bell.svg"></ion-icon>
                    </button>
                    <div class="dropdown-menu">
                        <span class="span-dropdown-indicator">&nbsp;</span>
                        <ul class="dropdown-menu-list notifications-menu-list">
                            <li class="dropdown-menu-list-item notifications-menu-list-item">
                                <div class="div-notifications-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/loader.svg"></ion-icon>
                                </div>
                                <div class="div-notifications-info-container">
                                    <h4>Notification Title</h4>
                                    <span>Time Ago</span>
                                </div>
                            </li>
                            <li class="dropdown-menu-list-item notifications-menu-list-item">
                                <div class="div-notifications-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/loader.svg"></ion-icon>
                                </div>
                                <div class="div-notifications-info-container">
                                    <h4>Notification Title</h4>
                                    <span>Time Ago</span>
                                </div>
                            </li>
                            <li class="dropdown-menu-list-item notifications-menu-list-item">
                                <div class="div-notifications-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/loader.svg"></ion-icon>
                                </div>
                                <div class="div-notifications-info-container">
                                    <h4>Notification Title</h4>
                                    <span>Time Ago</span>
                                </div>
                            </li>
                            <li class="dropdown-menu-list-item notifications-menu-list-item">
                                <div class="div-notifications-icon-container flex-center">
                                    <ion-icon src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/loader.svg"></ion-icon>
                                </div>
                                <div class="div-notifications-info-container">
                                    <h4>Notification Title</h4>
                                    <span>Time Ago</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="dropdown-container dropdown-user">
                    <button class="btn btn-icon btn-nav-icon">
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

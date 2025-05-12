    <!-- DIV CHAT MENU CONTAINER -->
    <div class="div-chat-menu-container">
        <div class="div-chat-menu hide-chat-menu">
            <header class="chat-menu-header flex-between">
                <h2 class="chat-menu-header-heading">Chat Room</h2>
                <nav class="chat-menu-navigation">
                    <ul class="chat-menu-nav-list">
                        <li class="chat-menu-nav-list-item">
                            <button class="btn btn-icon btn-chat-nav-icon active-btn-icon" data-chat-list="messages" data-header-title="Chat Room">
                                <ion-icon src="<?php echo ICON_PATH; ?>/message-circle.svg"></ion-icon>
                            </button>
                        </li>
                        <li class="chat-menu-nav-list-item">
                            <button class="btn btn-icon btn-chat-nav-icon" data-chat-list="users" data-header-title="Active Users">
                                <ion-icon src="<?php echo ICON_PATH; ?>/users.svg"></ion-icon>
                            </button>
                        </li>
                        <li class="chat-menu-nav-list-item">
                            <button class="btn btn-icon btn-chat-nav-icon btn-toggle-chat-menu" data-header-title="Chat Room">
                                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
                            </button>
                        </li>
                    </ul>
                </nav>
            </header>
            <div class="div-chat-overview-container">
                <?php require __DIR__ . '/../loaders/data-loader.php'; ?>
                <div class="div-chat-list-container div-chat-messages-list-container">
                    <?php require __DIR__ . '/../signs/none-chat-messages.php'; ?>
                    <ul class="chat-messages-list">
                        <!-- DYNAMICALLY GENERATED MESSAGES VIA AJAX -->
                    </ul>
                </div>
                <div class="div-chat-list-container div-chat-users-list-container hide-element">
                    <ul class="chat-users-list">
                        <!-- DYNAMICALLY GENERATED USERS VIA AJAX -->
                    </ul>
                </div>
            </div>
            <form class="form form-post-chat-message flex-between" action="/api/" method="POST">
                <div class="div-input-container">
                    <input id="chat_message" type="text" name="chat_message" placeholder="Your message..." autocomplete="off" required>
                </div>
                <button class="btn btn-icon btn-post-chat-message" type="submit">
                    <ion-icon src="<?php echo ICON_PATH; ?>/send.svg"></ion-icon>
                </button>
                <div class="div-hidden-inputs">
                    <input type="hidden" name="csrf_token" value="<?php Session::get('csrf_token'); ?>">
                </div>
            </form>
        </div>
        <div class="div-show-chat-menu-btn-container">
            <button class="btn btn-icon btn-show-chat-menu btn-toggle-chat-menu">
                <ion-icon src="<?php echo ICON_PATH; ?>/message-circle.svg"></ion-icon>
            </button>
        </div>
        <div class="div-hidden-inputs">
            <input id="partial_menu" type="hidden" name="partial_menu" value="partials/chat">
        </div>
    </div>

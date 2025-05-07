    <!-- DIV CHAT MENU CONTAINER -->
    <div class="div-chat-menu-container">
        <div class="div-chat-menu hide-chat-menu">
            <header class="chat-menu-header flex-between">
                <h2 class="chat-menu-header-heading">Chat Room</h2>
                <button class="btn btn-primary btn-close-chat-menu btn-toggle-chat-menu">Close</button>
            </header>
            <form class="form form-post-chat-message flex-between" action="/api/" method="POST">
                <div class="div-input-container">
                    <input id="message" type="text" name="message" autocomplete="off">
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
    </div>

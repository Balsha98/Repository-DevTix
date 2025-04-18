    <!-- LOGOUT MODAL CONTAINER -->
    <div class="div-logout-modal-container absolute-center hide-logout-modal">
        <div class="div-logout-modal absolute-center">
            <button class="btn btn-icon btn-close-logout-modal">
                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
            </button>
            <header class="logout-modal-header">
                <h2>Logout Confirmation</h2>
                <p>Are you <span>sure</span> about logging out?</p>
            </header>
            <div class="div-grid-btn-container div-grid-logout-modal-btn-container grid-2-columns">
                <button class="btn btn-error flex-center btn-close-logout-modal">
                    <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
                    <span>Cancel Logout</span>
                </button>
                <a class="link link-success flex-center" href="/logout">
                    <ion-icon src="<?php echo ICON_PATH; ?>/log-out.svg"></ion-icon>
                    <span>Confirm Logout</span>
                </a>
            </div>
        </div>
    </div>

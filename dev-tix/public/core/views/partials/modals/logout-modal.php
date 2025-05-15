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
            <form class="form form-user-logout grid-2-columns" action="/api/" method="PUT">
                <button class="btn btn-error btn-close-logout-modal flex-center" type="button">
                    <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
                    <span>Cancel</span>
                </button>
                <button class="btn btn-success btn-logout flex-center" data-view="views/logout">
                    <ion-icon src="<?php echo ICON_PATH; ?>/log-out.svg"></ion-icon>
                    <span>Confirm</span>
                </button>
            </form>
        </div>
    </div>

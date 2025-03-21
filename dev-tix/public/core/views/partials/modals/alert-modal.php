    <!-- ALERT -->
    <div class="div-alert-modal-container fixed-center hide-alert">
        <div class="div-alert-modal absolute-center">
            <div class="div-alert-modal-icon-container flex-center">
                <ion-icon 
                    class="alert-modal-icon" 
                    src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/check.svg"
                ></ion-icon>
            </div>
            <div class="div-alert-modal-content-container">
                <header class="alert-modal-content-header">
                    <h2 class="alert-modal-heading">Some Modal Heading</h2>
                    <p class="alert-modal-message">Message received through the API.</p>
                </header>
                <div class="div-alert-modal-btn-container">
                    <button class="btn btn-primary btn-alert-modal-close">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ALERT -->
    <div class="div-alert-container fixed-center hide-alert">
        <div class="div-alert-modal absolute-center">
            <div class="div-alert-icon-container flex-center">
                <ion-icon 
                    class="alert-icon" 
                    src="<?php echo SERVER_PATH; ?>/core/assets/media/icons/check.svg"
                ></ion-icon>
            </div>
            <div class="div-alert-content-container">
                <header class="alert-content-header">
                    <h2 class="alert-heading">Some Modal Heading</h2>
                    <p class="alert-message">Message received through the API.</p>
                </header>
                <div class="div-alert-btn-container">
                    <button class="btn btn-primary btn-alert-close">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

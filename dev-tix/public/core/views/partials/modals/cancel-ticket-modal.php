    <!-- CANCEL-TICKET MODAL CONTAINER -->
    <div class="div-cancel-ticket-modal-container absolute-center hide-cancel-ticket-modal">
        <div class="div-cancel-ticket-modal absolute-center">
            <button class="btn btn-icon btn-close-cancel-ticket-modal">
                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
            </button>
            <header class="cancel-ticket-modal-header">
                <h2>Cancellation Confirmation</h2>
                <p>Are you sure about <span>cancelling</span> your ticket?</p>
            </header>
            <div class="div-grid-btn-container div-grid-cancel-ticket-modal-btn-container grid-2-columns" data-url="/api/">
                <button class="btn btn-error btn-close-cancel-ticket-modal flex-center">
                    <ion-icon src="<?php echo ICON_PATH; ?>/arrow-left.svg"></ion-icon>
                    <span>Back</span>
                </button>
                <button class="btn btn-success btn-alter-request flex-center" data-method="PUT" data-status="cancelled">
                    <ion-icon src="<?php echo ICON_PATH; ?>/check.svg"></ion-icon>
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>

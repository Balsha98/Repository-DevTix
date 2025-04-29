    <!-- RESOLVE-TICKET MODAL CONTAINER -->
    <div class="div-resolve-ticket-modal-container absolute-center hide-resolve-ticket-modal">
        <div class="div-resolve-ticket-modal absolute-center">
            <button class="btn btn-icon btn-close-resolve-ticket-modal">
                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
            </button>
            <header class="resolve-ticket-modal-header">
                <h2>Resolvement Confirmation</h2>
                <p>Are you sure about <span>resolving</span> this ticket?</p>
            </header>
            <div class="div-grid-btn-container div-grid-resolve-ticket-modal-btn-container grid-2-columns" data-url="/api/">
                <button class="btn btn-error btn-close-resolve-ticket-modal flex-center">
                    <ion-icon src="<?php echo ICON_PATH; ?>/arrow-left.svg"></ion-icon>
                    <span>Back</span>
                </button>
                <button class="btn btn-success btn-alter-request flex-center" data-method="PUT" data-status="resolved">
                    <ion-icon src="<?php echo ICON_PATH; ?>/check.svg"></ion-icon>
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>

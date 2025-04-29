    <!-- POST-TICKET MODAL CONTAINER -->
    <div class="div-post-ticket-modal-container absolute-center hide-post-ticket-modal">
        <div class="div-post-ticket-modal absolute-center">
            <button class="btn btn-icon btn-close-post-ticket-modal">
                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
            </button>
            <header class="post-ticket-modal-header">
                <h2>Ticket Post Confirmation</h2>
                <p>Are you sure about <span>posting</span> this ticket?</p>
            </header>
            <div class="div-grid-btn-container div-grid-post-ticket-modal-btn-container grid-2-columns" data-url="/api/">
                <button class="btn btn-error btn-close-post-ticket-modal flex-center">
                    <ion-icon src="<?php echo ICON_PATH; ?>/arrow-left.svg"></ion-icon>
                    <span>Back</span>
                </button>
                <button class="btn btn-success btn-post-request flex-center" data-method="POST">
                    <ion-icon src="<?php echo ICON_PATH; ?>/check.svg"></ion-icon>
                    <span>Confirm</span>
                </button>
            </div>
        </div>
    </div>

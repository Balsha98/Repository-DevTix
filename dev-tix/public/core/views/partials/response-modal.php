    <!-- RESPONSE MODAL CONTAINER -->
    <div class="div-response-modal-container absolute-center hide-response-modal">
        <div class="div-response-modal absolute-center">
            <button class="btn btn-icon btn-toggle-response-modal">
                <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
            </button>
            <header class="response-modal-header">
                <h2>Post Your Response</h2>
                <p>Leave your <span>response</span> in the below textarea.</p>
            </header>
            <form class="form form-post-response" action="/api/" method="POST">
                <div class="div-input-container div-textarea-container required-container">
                    <label class="absolute-y-center label-textarea" for="question">
                        <ion-icon src="<?php echo ICON_PATH; ?>/help-circle.svg"></ion-icon>
                    </label>
                    <textarea id="question" name="question" placeholder="Write Your Question Here" required></textarea>
                </div>
                <div class="div-grid-btn-container grid-2-columns">
                    <button class="btn btn-error flex-center btn-toggle-response-modal" type="button">
                        <ion-icon src="<?php echo ICON_PATH; ?>/x.svg"></ion-icon>
                        <span>Cancel Response</span>
                    </button>
                    <button class="btn btn-success btn-post-response flex-center" type="submit">
                        <ion-icon src="<?php echo ICON_PATH; ?>/wind.svg"></ion-icon>
                        <span>Post Response</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

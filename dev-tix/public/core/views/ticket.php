<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

require_once __DIR__ . '/partials/page-loader.php';
require_once __DIR__ . '/partials/alert.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- TICKETS CONTAINER -->
            <div class="div-ticket-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-ticket-content-container">
                    <header class="ticket-container-header flex-between">
                        <h2 class="ticket-container-header-heading">
                            Ticket <span class="span-ticket-id">New</span> Overview
                        </h2>
                        <div class="div-ticket-actions-container">
                            <?php
                            if ($user->getRoleId() !== 2) {
                                if (Session::isSet('record_id') && Session::get('record_id') === 0) {
                                    echo '
                                        <button class="btn btn-primary btn-save" data-method="POST">
                                            <ion-icon src="' . ICON_PATH . '/paperclip.svg"></ion-icon>
                                            <span>Post Request</span>
                                        </button>
                                    ';
                                } else if (Session::isSet('record_id') && Session::get('record_id') !== 0) {
                                    // TODO: Check if ticket was responded to:
                                    // if it was, create some text that shows who the
                                    // assistant is, instead of the buttons.
                                    echo '
                                        <button class="btn btn-error btn-delete" data-method="DELETE">
                                            <ion-icon src="' . ICON_PATH . '/x.svg"></ion-icon>
                                            <span>Cancel</span>
                                        </button>
                                        <button class="btn btn-primary btn-save" data-method="POST/PUT">
                                            <ion-icon src="' . ICON_PATH . '/save.svg"></ion-icon>
                                            <span>Save Changes</span>
                                        </button>
                                    ';
                                }
                            } else if ($user->getRoleId() === 2) {
                                if (Session::isSet('record_id') && Session::get('record_id') !== 0) {
                                    // TODO: Check whether this assistant user has this
                                    // record_id (request_id) inside the database: if this
                                    // is true, create a resolve (success) button.

                                    // TODO: Check whether this assistant user has this
                                    // record_id (request_id) inside the database: if this
                                    // is NOT true, create a button to assign the request
                                    // to himself/herself.

                                    // TODO: When an assistant is viewing a ticket that was not
                                    // assigned to him/her, but the ticket was assigned to somebody else,
                                    // then the assistant can only view this interaction:
                                    // he/she cannot participate in the conversation.
                                }
                            }

                            ?>
                        </div>
                    </header>
                    <div class="div-ticket-overview-container">
                        <form class="form form-create-ticket" action="/api/" data-form-type="create">
                            <div class="div-form-create-ticket-inputs-container">
                                <div class="div-input-container required-container">
                                    <label class="absolute-y-center label-select" for="type">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                    </label>
                                    <select id="type" name="type" required>
                                        <option value="0">Select Ticket Issue Type</option>
                                        <option value="Web Development">Web Development Issue</option>
                                        <option value="Frontend">Frontend Issue</option>
                                        <option value="Backend">Backend Issue</option>
                                        <option value="Full-Stack">Full-Stack Issue</option>
                                        <option value="Programming">Programming Issue</option>
                                        <option value="Artificial Intelligence">Artificial Intelligence Issue</option>
                                        <option value="Database">Database Issue</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="div-input-container required-container">
                                    <label class="absolute-y-center" for="subject">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/book.svg"></ion-icon>
                                    </label>
                                    <input id="subject" type="text" name="subject" placeholder="Ticket Subject Here" required>
                                </div>
                                <div class="div-input-container div-textarea-container required-container">
                                    <label class="absolute-y-center label-textarea" for="question">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/help-circle.svg"></ion-icon>
                                    </label>
                                    <textarea id="question" name="question" placeholder="Write Your Question Here"></textarea>
                                </div>
                            </div>
                            <div class="div-form-create-ticket-images-container">
                                <header class="form-create-ticket-images-container-header">
                                    <h4>Code Snippets</h4>
                                    <p>Post screenshots of your code.</p>
                                </header>
                                <ul class="form-create-image-inputs-list">
                                    <li class="form-create-image-inputs-list-item">
                                        <label class="absolute-y-center input-image-label flex-center" for="image_1">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/image.svg"></ion-icon>
                                        </label>
                                        <div class="div-input-image-container">
                                            <input id="image_name_1" class="input-image-name" type="text" name="image_name" value="Image Name" readonly>
                                            <label class="btn btn-primary" for="image_1" role="button">Upload</label>
                                            <input id="image_1" class="input-image" type="file" name="image">
                                        </div>
                                    </li>
                                    <li class="form-create-image-inputs-list-item flex-center">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/info.svg"></ion-icon>
                                        <p>You have <span class="span-total-images">5</span> images remaining.</p>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <form class="form form-alter-ticket hide-element" action="/api/" data-form-type="alter">
                            <!-- TODO: CREATE NEW TYPE OF VIEW -->
                        </form>
                    </div>
                    <footer class="ticket-container-footer flex-between">
                        <p>Request Action: <span class="span-request-action">Create</span></p>
                        <p>Viewing Since: <span><?php echo date('H:i:s') ?></span></p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/ticket">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                <?php $recordID = Session::isSet('record_id') ? Session::get('record_id') : 0; ?>
                <input id="record_id" type="hidden" name="record_id" value="<?php echo $recordID; ?>">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
            </div>
        </main>
    </div>

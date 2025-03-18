<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';
require_once __DIR__ . '/../../../source/classes/models/Request.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

// Check if we're viewing an existing request.
// and set the other data appropriately.
$isRecordIdSet = Session::isSet('record_id');
$recordID = $isRecordIdSet ? (int) Session::get('record_id') : 0;

require_once __DIR__ . '/partials/page-loader.php';
require_once __DIR__ . '/partials/image-modal.php';
require_once __DIR__ . '/partials/alert.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- TICKETS CONTAINER -->
            <div class="div-main-container div-ticket-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-ticket-content-container">
                    <header class="ticket-container-header flex-between">
                        <h2 class="ticket-container-header-heading">
                            Ticket <span class="span-ticket-id">New</span> Overview
                        </h2>
                        <div class="div-ticket-actions-container">
                            <?php
                            if ($user->getRoleId() !== 2) {
                                if ($isRecordIdSet && $recordID === 0) {
                                    echo '
                                        <button class="btn btn-success btn-post" data-method="POST">
                                            <ion-icon src="' . ICON_PATH . '/paperclip.svg"></ion-icon>
                                            <span>Post Request</span>
                                        </button>
                                    ';
                                } else if ($isRecordIdSet && $recordID !== 0) {
                                    $request = new Request($recordID, Session::getDbInstance());

                                    if ($request->getStatus() !== 'unassigned') {
                                        $assistant = new User($request->getAssistantId(), Session::getDbInstance());

                                        echo '
                                            <button class="btn btn-success btn-show-modal">
                                                <ion-icon src="' . ICON_PATH . '/wind.svg"></ion-icon>
                                                <span>Post Response</span>
                                            </button>
                                        ';
                                    } else {
                                        echo '
                                            <button class="btn btn-error btn-cancel" data-method="DELETE">
                                                <ion-icon src="' . ICON_PATH . '/x.svg"></ion-icon>
                                                <span>Cancel Request</span>
                                            </button>
                                        ';
                                    }
                                }
                            } else if ($user->getRoleId() === 2) {
                                if ($isRecordIdSet && $recordID !== 0) {
                                    if (in_array($recordID, $user->getRequestIDs())) {
                                        echo '
                                            <button class="btn btn-success btn-resolve" data-method="PUT">
                                                <ion-icon src="' . ICON_PATH . '/check.svg"></ion-icon>
                                                <span>Resolve Request</span>
                                            </button>
                                        ';
                                    } else if (!in_array($recordID, $user->getRequestIDs())) {
                                        $request = new Request($recordID, Session::getDbInstance());

                                        if ($request->getStatus() === 'unassigned') {
                                            echo '
                                                <button class="btn btn-pending btn-assign" data-method="PUT">
                                                    <ion-icon src="' . ICON_PATH . '/plus.svg"></ion-icon>
                                                    <span>Assign To Yourself</span>
                                                </button>
                                            ';
                                        } else {
                                            $assistant = new User($request->getAssistantId(), Session::getDbInstance());

                                            echo '
                                                <p class="text-assigned-to-assistant">
                                                    Assigned To: <span>' . $assistant->getUsername() . '</span>
                                                </p>
                                            ';
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </header>
                    <div class="div-ticket-overview-container">
                        <div class="div-ticket-data-container" data-container-type="request">
                            <form class="form form-post-ticket" action="/api/">
                                <div class="div-input-container required-container">
                                    <label class="absolute-y-center label-select" for="type">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                    </label>
                                    <select id="type" class="ticket-select-type" name="type" required>
                                        <option value="">Select Ticket Type</option>
                                        <option value="web development">Web Development</option>
                                        <option value="frontend">Frontend</option>
                                        <option value="backend">Backend</option>
                                        <option value="full-stack">Full-Stack</option>
                                        <option value="programming">Programming</option>
                                        <option value="artificial intelligence">Artificial Intelligence</option>
                                        <option value="database">Database</option>
                                        <option value="other">Other</option>
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
                                    <textarea id="question" name="question" placeholder="Write Your Question Here" required></textarea>
                                </div>
                            </form>
                            <form class="form form-upload-image" action="/api/" enctype="multipart/form-data">
                                <header class="form-upload-image-header">
                                    <h4>Code Snippets</h4>
                                    <p>Post screenshots of your code.</p>
                                </header>
                                <ul class="form-upload-image-inputs-list">
                                    <li class="form-upload-image-inputs-list-item" data-image-id="1">
                                        <label class="absolute-y-center input-image-label flex-center" for="image_name_1">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/image.svg"></ion-icon>
                                        </label>
                                        <div class="div-input-image-container">
                                            <input 
                                                id="image_name_1" class="input-image-name" type="text" 
                                                name="image_name" value="Image Name" readonly
                                            >
                                            <label class="btn btn-primary btn-upload" for="image_1" role="button">Upload</label>
                                            <input id="image_1" class="input-image" type="file" name="image">
                                        </div>
                                    </li>
                                    <li class="form-upload-image-inputs-list-item flex-center">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/info.svg"></ion-icon>
                                        <p>You have <span class="span-images-left">4</span> images remaining.</p>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <?php if ($isRecordIdSet && $recordID !== 0) { ?>
                        <div class="div-ticket-data-container" data-container-type="response">
                            <?php $request = new Request($recordID, Session::getDbInstance()); ?>
                            <div class="div-ticket-responses-container">
                                <div class="div-ticket-topic-container">
                                    <?php echo Image::renderTicketPatronImage($user); ?>
                                    <div class="div-ticket-topic-data-container">
                                        <header class="ticket-topic-data-container-header">
                                            <h4><?php echo $request->getSubject(); ?></h4>
                                        </header>
                                        <p><?php echo $request->getQuestion(); ?></p>
                                        <footer class="ticket-topic-data-container-footer">
                                            <p>Type: <span><?php echo $request->getType(); ?></span></p>
                                            <p>Posted: <span><?php echo $request->getPostedAt(); ?></span></p>
                                        </footer>
                                    </div>
                                </div>
                                <ul class="ticket-responses-list">
                                    <li class="ticket-responses-list-item">

                                    </li>
                                </ul>
                                <form class="form" action="/api/" method="POST">

                                </form>
                            </div>
                            <div class="div-ticket-images-container">
                                <header class="ticket-images-container-header">
                                    <h4>Code Snippets</h4>
                                    <p>Posted screenshots of the code.</p>
                                </header>
                                <ul class="ticket-images-list grid-2-columns">
                                    <li class="ticket-images-list-item">
                                        <div class="div-image-container">
                                            <img src="<?php echo IMAGE_PATH; ?>/login-banner.jpg" alt="Request Image">
                                        </div>
                                    </li>
                                    <li class="ticket-images-list-item">
                                        <div class="div-image-container">
                                            <img src="<?php echo IMAGE_PATH; ?>/login-banner.jpg" alt="Request Image">
                                        </div>
                                    </li>
                                    <li class="ticket-images-list-item">
                                        <div class="div-image-container">
                                            <img src="<?php echo IMAGE_PATH; ?>/login-banner.jpg" alt="Request Image">
                                        </div>
                                    </li>
                                    <li class="ticket-images-list-item">
                                        <div class="div-image-container">
                                            <img src="<?php echo IMAGE_PATH; ?>/login-banner.jpg" alt="Request Image">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <footer class="ticket-container-footer flex-between">
                        <p>Request Action: <span class="span-request-action">Request</span></p>
                        <p>Viewing Since: <span><?php echo date('H:i:s') ?></span></p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/ticket">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                <input id="record_id" type="hidden" name="record_id" value="<?php echo $recordID; ?>">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
            </div>
        </main>
    </div>

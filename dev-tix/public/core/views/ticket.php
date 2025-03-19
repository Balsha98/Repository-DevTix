<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';
require_once __DIR__ . '/../../../source/classes/models/Request.php';
require_once __DIR__ . '/../../../source/classes/models/Response.php';

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
                        <div class="div-ticket-actions-container" data-url="/api/">
                            <?php
                            if ($user->getRoleId() !== 2) {
                                if ($isRecordIdSet && $recordID === 0) {
                                    echo '
                                        <button class="btn btn-success btn-post-request" data-method="POST">
                                            <ion-icon src="' . ICON_PATH . '/paperclip.svg"></ion-icon>
                                            <span>Post Request</span>
                                        </button>
                                    ';
                                } else if ($isRecordIdSet && $recordID !== 0) {
                                    $request = new Request($recordID, Session::getDbInstance());

                                    if ($request->getStatus() !== 'unassigned') {
                                        if ($request->getStatus() === 'resolved') {
                                            $assistant = new User($request->getAssistantId(), Session::getDbInstance());

                                            echo '
                                                <p class="text-ticket-assignment">
                                                    Resolved By: <span>' . $assistant->getUsername() . '</span>
                                                </p>
                                            ';
                                        } else if ($user->getId() !== $request->getTurnId()) {
                                            $turnUser = new User($request->getTurnId(), Session::getDbInstance());

                                            echo '
                                                <p class="text-ticket-assignment">
                                                    Next Turn: <span>' . $turnUser->getUsername() . '</span>
                                                </p>
                                            ';
                                        } else {
                                            echo '
                                                <button class="btn btn-success btn-toggle-response-modal">
                                                    <ion-icon src="' . ICON_PATH . '/wind.svg"></ion-icon>
                                                    <span>Post Response</span>
                                                </button>
                                            ';
                                        }
                                    } else {
                                        echo '
                                            <button class="btn btn-error btn-alter-request" data-method="PUT" data-status="cancelled">
                                                <ion-icon src="' . ICON_PATH . '/x.svg"></ion-icon>
                                                <span>Cancel Request</span>
                                            </button>
                                        ';
                                    }
                                }
                            } else if ($user->getRoleId() === 2) {
                                if ($isRecordIdSet && $recordID !== 0) {
                                    $request = new Request($recordID, Session::getDbInstance());

                                    if (in_array($recordID, $user->getRequestIDs())) {
                                        if ($request->getTurnId() !== $user->getId()) {
                                            $turnUser = new User($request->getTurnId(), Session::getDbInstance());

                                            echo '
                                                <p class="text-ticket-assignment">
                                                    Next Turn: <span>' . $turnUser->getUsername() . '</span>
                                                </p>
                                            ';
                                        } else if ($request->getStatus() === 'resolved') {
                                            $assistant = new User($request->getAssistantId(), Session::getDbInstance());

                                            echo '
                                                <p class="text-ticket-assignment">
                                                    Resolved By: <span>' . $assistant->getUsername() . '</span>
                                                </p>
                                            ';
                                        } else {
                                            echo '
                                                <button class="btn btn-success btn-alter-request" data-method="PUT" data-status="resolved">
                                                    <ion-icon src="' . ICON_PATH . '/check.svg"></ion-icon>
                                                    <span>Resolve Request</span>
                                                </button>
                                                <button class="btn btn-primary btn-toggle-response-modal">
                                                    <ion-icon src="' . ICON_PATH . '/wind.svg"></ion-icon>
                                                    <span>Post Response</span>
                                                </button>
                                            ';
                                        }
                                    } else if (!in_array($recordID, $user->getRequestIDs())) {
                                        if ($request->getStatus() === 'unassigned') {
                                            echo '
                                                <button class="btn btn-pending btn-alter-request" data-method="PUT" data-status="pending">
                                                    <ion-icon src="' . ICON_PATH . '/plus.svg"></ion-icon>
                                                    <span>Claim Assignment</span>
                                                </button>
                                            ';
                                        } else {
                                            $assistant = new User($request->getAssistantId(), Session::getDbInstance());

                                            echo '
                                                <p class="text-ticket-assignment">
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
                                            <label class="btn btn-primary btn-upload-image" for="image_1" role="button">Upload</label>
                                            <input id="image_1" class="input-image" type="file" name="image">
                                        </div>
                                    </li>
                                    <li class="form-upload-image-inputs-list-item flex-center">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/info.svg"></ion-icon>
                                        <p>You have <span class="span-images-left">5</span> images remaining.</p>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <?php if ($isRecordIdSet && $recordID !== 0) { ?>
                        <div class="div-ticket-data-container" data-container-type="response">
                            <?php
                            require_once __DIR__ . '/partials/response-modal.php';
                            $request = new Request($recordID, Session::getDbInstance());
                            $requestUser = new User($request->getPatronId(), Session::getDbInstance());
                            ?>
                            <div class="div-ticket-responses-container">
                                <div class="div-scrollable-responses-container">
                                    <div class="div-ticket-topic-container">
                                        <?php echo Image::renderTicketPatronImage($requestUser); ?>
                                        <div class="div-ticket-topic-data-container">
                                            <header class="ticket-topic-data-container-header">
                                                <h4><?php echo $request->getSubject(); ?></h4>
                                                <span><?php echo $request->getType(); ?></span>
                                            </header>
                                            <p><?php echo $request->getQuestion(); ?></p>
                                            <footer class="ticket-topic-data-container-footer">
                                                <p>User: <span><?php echo $requestUser->getUsername(); ?></span></p>
                                                <p>Posted: <span><?php echo $request->getPostedAt(); ?></span></p>
                                            </footer>
                                        </div>
                                    </div>
                                    <ul class="ticket-responses-list">
                                        <?php
                                        $responseIDs = $request->getResponseIDs();
                                        if (!empty($responseIDs)) {
                                            foreach ($responseIDs as $responseID) {
                                                $response = new Response($responseID, Session::getDbInstance());
                                                $responseUser = new User($response->getUserId(), Session::getDbInstance());

                                                echo '
                                                    <li class="ticket-responses-list-item">
                                                        ' . Image::renderTicketPatronImage($responseUser) . '
                                                        <div class="div-ticket-response-data-container">
                                                            <p>' . $response->getResponse() . '</p>
                                                            <footer class="ticket-response-data-container-footer flex-between">
                                                                <p>User: <span>' . $responseUser->getUsername() . '</span></p>
                                                                <p>Posted: <span>' . $response->getPostedAt() . '</span></p>
                                                            </footer>
                                                        </div>
                                                    </li>
                                                ';
                                            }
                                        } else {
                                            require_once __DIR__ . '/partials/none-responses.php';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="div-ticket-images-container">
                                <header class="ticket-images-container-header">
                                    <h4>Code Snippets</h4>
                                    <p>Posted screenshots of the code.</p>
                                </header>
                                <ul class="ticket-images-list grid-2-columns">
                                    <?php
                                    $images = $request->getImages();
                                    if (!empty($images)) {
                                        foreach ($images as $image) {
                                            echo "
                                                <li class='ticket-images-list-item'>
                                                    <div class='div-image-container'>
                                                        <img class='ticket-image' src='data:image/jpg;base64,{$image}' alt='Request Image'>
                                                    </div>
                                                </li>
                                            ";
                                        }
                                    } else {
                                        require_once __DIR__ . '/partials/none-images.php';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <footer class="ticket-container-footer flex-between">
                        <p>Request Action: <span class="span-request-action">Request</span></p>
                        <p>Viewing Since: <span><?php echo date('H:i:s'); ?></span></p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/ticket">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo Session::get('view_as_user_id'); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                <input id="record_id" type="hidden" name="record_id" value="<?php echo $recordID; ?>">
            </div>
        </main>
    </div>

<?php
// Import needed models.
// TODO: Might create custom autoloader.
require_once __DIR__ . '/../../../source/classes/models/User.php';

$user = new User(Session::get('user_id'), Session::getDbInstance());

// Check if we're viewing an existing request.
// and set the other data appropriately.
$isRecordIdSet = Session::isSet('record_id');
$recordID = $isRecordIdSet ? (int) Session::get('record_id') : 0;

require_once __DIR__ . '/partials/loaders/page-loader.php';
require_once __DIR__ . '/partials/modals/alert-modal.php';
?>

    <!-- MAIN CONTAINER -->
    <div class="centered-container">
        <main class="main-container">
            <?php require_once __DIR__ . '/partials/sidebar.php'; ?>
            <!-- PROFILE CONTAINER -->
            <div class="div-main-container div-profile-container">
                <?php require_once __DIR__ . '/partials/navigation.php'; ?>
                <div class="div-profile-content-container">
                    <header class="profile-container-header flex-between">
                        <h2 class="profile-container-header-heading">
                            <span class="span-profile-user">New User</span> Profile Overview
                        </h2>
                        <div class="div-profile-actions-container" data-url="/api/">
                            <?php
                            if ($isRecordIdSet && $recordID === 0) {
                                if ($user->getRoleId() === 1) {
                                    echo '
                                        <button class="btn btn-success btn-create-user" data-method="POST">
                                            <ion-icon src="' . ICON_PATH . '/user.svg"></ion-icon>
                                            <span>Create User</span>
                                        </button>
                                    ';
                                }
                            } else if ($isRecordIdSet && $recordID !== 0) {
                                if ($user->getId() !== $recordID && $user->getViewAsRoleId() === 1) {
                                    echo '
                                        <button class="btn btn-error btn-delete-user" data-method="DELETE">
                                            <ion-icon src="' . ICON_PATH . '/x.svg"></ion-icon>
                                            <span>Delete User</span>
                                        </button>
                                    ';
                                }

                                if ($user->getViewAsUserId() === $recordID || $user->getViewAsRoleId() === 1) {
                                    echo '
                                        <button class="btn btn-primary btn-create-user" data-method="PUT">
                                            <ion-icon src="' . ICON_PATH . '/user.svg"></ion-icon>
                                            <span>Update User</span>
                                        </button>
                                    ';
                                }
                            }
                            ?>
                        </div>
                    </header>
                    <div class="div-profile-overview-container">
                        <form class="form form-profile" action="/api/">
                            <div class="div-user-details-container">
                                <div class="div-image-container div-profile-image-container">
                                    <img src="<?php echo IMAGE_PATH; ?>/placeholder-user.jpg" alt="Profile Image">
                                </div>
                                <div class="div-input-image-outer-container">
                                    <label class="absolute-y-center input-image-label flex-center" for="image_name">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/image.svg"></ion-icon>
                                    </label>
                                    <div class="div-input-image-inner-container">
                                        <input 
                                            id="image_name" class="input-image-name" type="text" 
                                            name="image_name" placeholder="Image Name" readonly
                                        >
                                        <label class="btn btn-primary btn-upload-image" for="image" role="button">Upload</label>
                                        <input id="image" class="input-image" type="file" name="image" accept=".png, .jpg, .jpeg">
                                    </div>
                                </div>
                                <div class="div-input-container">
                                    <label class="absolute-y-center" for="username">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/user.svg"></ion-icon>
                                    </label>
                                    <input id="username" type="text" name="username" placeholder="Username">
                                </div>
                                <?php if ($user->getViewAsUserId() === $recordID) { ?>
                                <div class="div-grid-link-container">
                                    <a class="link link-primary link-forgot-password" href="/forgot-password">
                                        Forgot Password?
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="div-user-details-container">
                                <div class="div-multiple-inputs-grid grid-2-columns">
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="first_name">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/user.svg"></ion-icon>
                                        </label>
                                        <input id="first_name" type="text" name="first_name" placeholder="First Name">
                                    </div>
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="last_name">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/user.svg"></ion-icon>
                                        </label>
                                        <input id="last_name" type="text" name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="div-multiple-inputs-grid grid-2-columns">
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="email">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/mail.svg"></ion-icon>
                                        </label>
                                        <input id="email" type="email" name="email" placeholder="Email Address">
                                    </div>
                                    <div class="div-input-container">
                                        <label class="label-select absolute-y-center" for="role">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                        </label>
                                        <select id="role" name="role">
                                            <option value="">Select Role</option>
                                            <?php if ($user->getViewAsRoleId() === 1) { ?>
                                            <option value="1">Administrator</option>
                                            <?php } ?>
                                            <option value="2">Assistant</option>
                                            <option value="3">Patron</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="div-input-container div-textarea-container">
                                    <label class="absolute-y-center label-textarea" for="bio">
                                        <ion-icon src="<?php echo ICON_PATH; ?>/feather.svg"></ion-icon>
                                    </label>
                                    <textarea id="bio" name="bio" placeholder="Write Your Bio Here"></textarea>
                                </div>
                                <div class="div-multiple-inputs-grid grid-2-columns">
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="age">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/bar-chart-2.svg"></ion-icon>
                                        </label>
                                        <input id="age" type="number" name="age" min="0" placeholder="Age">
                                    </div>
                                    <div class="div-input-container">
                                        <label class="label-select absolute-y-center" for="gender">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/chevron-down.svg"></ion-icon>
                                        </label>
                                        <select id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="div-multiple-inputs-grid grid-2-columns">
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="profession">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/activity.svg"></ion-icon>
                                        </label>
                                        <input id="profession" type="text" name="profession" placeholder="Profession">
                                    </div>
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="country">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/map.svg"></ion-icon>
                                        </label>
                                        <input id="country" type="text" name="country" placeholder="Country">
                                    </div>
                                </div>
                                <div class="div-multiple-inputs-grid grid-2-columns">
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="city">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/map-pin.svg"></ion-icon>
                                        </label>
                                        <input id="city" type="text" name="city" placeholder="City">
                                    </div>
                                    <div class="div-input-container">
                                        <label class="absolute-y-center" for="zip">
                                            <ion-icon src="<?php echo ICON_PATH; ?>/target.svg"></ion-icon>
                                        </label>
                                        <input id="zip" type="number" name="zip" min="0" placeholder="Zip Code">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <footer class="profile-container-footer flex-between">
                        <p>User View: <span class="span-profile-view">New</span></p>
                        <p>Viewing Since: <span><?php echo date('H:i:s'); ?></span></p>
                    </footer>
                </div>
            </div>
            <div class="div-hidden-inputs">
                <input id="view" type="hidden" name="view" value="views/profile">
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                <input id="csrf_token" type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">
                <input id="record_id" type="hidden" name="record_id" value="<?php echo $recordID; ?>">
            </div>
        </main>
    </div>

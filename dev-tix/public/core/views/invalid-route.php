    <!-- INVALID ROUTE -->
    <div class="div-invalid-route-container absolute-center">
        <h1 class="invalid-route-heading">Oops!</h1>
        <div class="div-invalid-route-content-container">
            <header class="invalid-route-content-header">
                <h3>Requested Page Was Not Found</h3>
                <p>The page you are looking for unfortunately does not exist.</p>
            </header>
            <?php $lastRoute = Session::isSet('last_route') ? Session::get('last_route') : '/welcome'; ?>
            <a class="link link-primary" href="<?php echo $lastRoute; ?>">
                Back To Previous
            </a>
        </div>
    </div>

    <!-- IMPORTED JS SCRIPTS -->
    <?php echo Template::buildPageImportedModules($page); ?>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="<?php echo SERVER_PATH; ?>/core/assets/javascript/libraries/jQuery.js"></script>
    <!-- CUSTOM JS SCRIPTS -->
    <?php echo Template::buildPageModule($page); ?>
</body>

</html>

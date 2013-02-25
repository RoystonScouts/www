<div class="wrap">
    <h2>Royston Scouts Settings</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('royston_scouts-test-group'); ?>
        <?php @do_settings_fields('royston_scouts-test-group'); ?>

        <?php do_settings_sections('royston_scouts'); ?>

        <?php @submit_button(); ?>
    </form>
</div>

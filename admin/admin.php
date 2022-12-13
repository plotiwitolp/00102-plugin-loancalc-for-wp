<h1 class="loancalc-title"><?php esc_html_e('Loan Calc Settings', 'loancalc'); ?></h1>
<?php settings_errors(); ?>
<div class="loancalc_content">
    <form method="post" action="options.php">
        <?php
        settings_fields('loancalc_settings');
        do_settings_sections('loan_calc_slug');
        submit_button();
        ?>
    </form>
</div>
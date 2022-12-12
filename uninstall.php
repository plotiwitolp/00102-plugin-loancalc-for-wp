    <?php
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        die;
    }
    //delete post type from db

    // global $wpdb;
    // $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type IN ('loan-calc');");

    $loanCalcValues = get_posts(['post_type' => 'loan-calc', 'numberposts' => -1]);

    foreach ($loanCalcValues as $loanCalcValue) {
        $wp_delete_post($loanCalcValue->ID, true); // true - удаляет пост из всех мест (корзина, черновик...)
    }

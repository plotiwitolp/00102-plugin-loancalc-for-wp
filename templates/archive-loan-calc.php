<?php
get_header();

$options = get_option('loancalc_settings_options');
?>

<div class="wrapper">

    <?php if (isset($options['title_for_loancalc_params'])) {
        echo '<h1>' . $options['title_for_loancalc_params'] . '</h1>';
    } ?>
    <!-- test -->
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
    ?>
            <acrticle id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1>
                    <a href="<? the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h1>
                <?php the_excerpt(); ?>
            </acrticle>
            <div class="paginate_wrapper">
                <?php echo paginate_links(); ?>
            </div>
    <?php
        }
    } else {
        echo  esc_html__('no posts', 'loancalc');
    }

    ?>
</div>

<?php
get_footer();

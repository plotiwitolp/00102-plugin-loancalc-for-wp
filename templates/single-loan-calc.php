<?php
get_header();
?>

<div class="wrapper">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
    ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
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

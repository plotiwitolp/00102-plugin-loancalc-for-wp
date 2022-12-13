<?php
/* Plugin name: Loan Calc 
Version: 1.0
Description: plugin Loan Calc 
Author: Ivan Plotnikov
*/
if (!defined('ABSPATH')) {
  die;
}

class LoanCalc
{
  public function registering()
  {
    add_action('init', [$this, 'custom_type']);
    add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_front']);
    add_action('admin_menu', [$this, 'admin_menu_plug']);

    add_action('admin_init', [$this, 'setting_init']);

    add_filter('template_include', [$this, 'loan_calc__template']);
    add_filter('excerpt_length', [$this, 'change_excerpt_length']);
    add_filter('excerpt_more', [$this, 'wpdocs_excerpt_more']);

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'add_plugin_setting_links']);
  }

  public function add_plugin_setting_links($link)
  {
    $suctom_link = '<a href="admin.php?page=loan_calc_slug">' . esc_html__('Settings', 'loancalc') . '</a>';
    array_push($link, $suctom_link);
    return $link;
  }

  public function setting_init()
  {
    register_setting('loancalc_settings', 'loancalc_settings_options'); // вордпресс функция
    add_settings_section( // вордпресс функция
      'loancalc_settings_section',
      esc_html__('Settings', 'loancalc'),
      [$this, 'settings_section_html'],
      'loan_calc_slug'
    );
    add_settings_field( // вордпресс функция
      'posts_per_page',
      esc_html__('Posts per page', 'loancalc'),
      [$this, 'posts_per_page_html'],
      'loan_calc_slug',
      'loancalc_settings_section'
    );
    add_settings_field( // вордпресс функция
      'title_for_loancalc_params',
      esc_html__('Title for Loan Calc', 'loancalc'),
      [$this, 'title_for_loancalc_params_html'],
      'loan_calc_slug',
      'loancalc_settings_section'
    );
  }

  public function settings_section_html()
  {
    echo esc_html__("Какое-то описание чего-либо как пример.", 'loancalc');
  }
  public function posts_per_page_html()
  {
    $options = get_option('loancalc_settings_options'); ?>
    <input type="text" name="loancalc_settings_options[posts_per_page]" value="<?php echo isset($options['posts_per_page']) ? $options['posts_per_page'] : ""  ?>">
  <?php }

  public function title_for_loancalc_params_html()
  {
    $options = get_option('loancalc_settings_options'); ?>
    <input type="text" name="loancalc_settings_options[title_for_loancalc_params]" value="<?php echo isset($options['title_for_loancalc_params']) ? $options['title_for_loancalc_params'] : ""  ?>">
<?php }

  static function activation()
  {
    // update rewrite rules
    flush_rewrite_rules();
  }
  static function deactivation()
  {
    // update rewrite rules
    flush_rewrite_rules();
  }

  public function change_excerpt_length($length)
  {
    return 15;
  }
  public function wpdocs_excerpt_more($more)
  {
    return ' <a href=' . get_permalink() . '>' . esc_html__('узнать больше', 'loancalc') .  '</a>';
  }

  public function admin_menu_plug()
  {
    add_menu_page(
      esc_html__('Loan Calc Title', 'loancalc'),
      esc_html__('Loan Calc Plugin' . 'loancalc'),
      'administrator',
      'loan_calc_slug',
      [$this, 'admin_plug_page'],
      'dashicons-table-col-before',
      51
    );
  }

  public function admin_plug_page()
  {
    require_once plugin_dir_path(__FILE__) . 'admin/admin.php';
  }

  public function loan_calc__template($template)
  {
    if (is_post_type_archive('loan-calc')) {
      $theme_files = ['archive-loan-calc.php', 'loancalc/archive-loan-calc.php'];
      $exist = locate_template($theme_files, false);
      if ($exist != '') {
        return $exist;
      } else {
        return plugin_dir_path(__FILE__) . 'templates/archive-loan-calc.php';
      }
    } elseif (is_single()) {
      return plugin_dir_path(__FILE__) . 'templates/single-loan-calc.php';
    }
    return $template;
  }

  public function enqueue_admin()
  {
    wp_enqueue_style('loancalcStyle', plugins_url('/assets/admin/style.css', __FILE__));
    wp_enqueue_script('loancalcScripts', plugins_url('/assets/admin/script.js', __FILE__));
  }
  public function enqueue_front()
  {
    wp_enqueue_style('loancalcStyle', plugins_url('/assets/front/style.css', __FILE__));
    wp_enqueue_script('loancalcScripts', plugins_url('/assets/front/script.js', __FILE__));
  }

  public function custom_type()
  {
    register_post_type('loan-calc', [
      'public' => true,
      'has_archive' => true, // чтобы post-type был доступен на front
      'rewrite' => ['slug' => 'loan-calc-params'], // чтобы данные обновились нужно просто зайти на страницу домен/wp-admin/options-permalink.php
      'label' => esc_html__('Loan Calc Posts', 'loancalc'),
      'supports' => ['title', 'editor',  'author', 'thumbnail']
    ]);
  }
}

if (class_exists('LoanCalc')) {
  $loan_calc = new LoanCalc();
  $loan_calc->registering();
}

register_activation_hook(__FILE__, array($loan_calc, 'activation'));
register_deactivation_hook(__FILE__, array($loan_calc, 'deactivation'));

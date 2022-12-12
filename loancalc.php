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
  public function __construct()
  {
    add_action('init', [$this, 'custom_type']);
  }

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


  public function custom_type()
  {
    register_post_type('loan-calc', [
      'public' => true,
      'label' => esc_html__('Loan Calc', 'loancalc'),
      'supports' => ['title', 'editor',  'author', 'thumbnail']
    ]);
  }
}

if (class_exists('LoanCalc')) {
  $loan_calc = new LoanCalc();
}

register_activation_hook(__FILE__, array($loan_calc, 'activation'));
register_deactivation_hook(__FILE__, array($loan_calc, 'deactivation'));

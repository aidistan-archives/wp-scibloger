<?php

class SciBloger_MathJax {

  // Constants
  const MENU_TITLE = 'MathJax';
  const PAGE_TITLE = 'SciBloger/MathJax';
  const MENU_SLUG  = 'scibloger_mathjax_page';


  function __construct() {
    // Main function
    if ( get_option( ScienceBlogHelper::OPTION_MATHJAX ) == 'on' )
      add_action( 'wp_head', array($this, 'insert_js_script' ), 10);

    // Admin actions
    if ( is_admin() && get_option( ScienceBlogHelper::OPTION_MODE ) == 'maximal' ){
      add_action( 'admin_menu', array($this, 'add_settings_page') );
      add_action( 'admin_init', array($this, 'init_settings_page') );  
    }
  }
  
  // Insert MathJax script
  function insert_js_script() {
  	echo '<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>';
  }

  function add_settings_page() {
    add_submenu_page(
      ScienceBlogHelper::MENU_SLUG, 
      self::PAGE_TITLE,
      self::MENU_TITLE,
      'manage_options',
      self::MENU_SLUG,
      array($this, 'create_settings_page')
    );
  }

  function create_settings_page() {
    echo 'Under construction.';
  }

  function init_settings_page() {

  }
}

?>
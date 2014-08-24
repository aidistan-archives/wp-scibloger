<?php

class SciBloger_MathJax {

  // Constants
  const MENU_TITLE = 'MathJax';
  const PAGE_TITLE = 'SciBloger/MathJax';
  const MENU_SLUG  = 'scibloger_mathjax_page';

  const OPTION_GROUP  = 'scibloger_outline_options';
  const OPTION_CONFIG = 'scibloger_outline_configuration';

  function __construct() {
    $this -> init_options();

    if ( get_option( ScienceBlogHelper::OPTION_MATHJAX ) == 'on' )
      add_action( 'wp_head', array($this, 'insert_js_script' ), 10);

    if ( is_admin() && get_option( ScienceBlogHelper::OPTION_MODE ) == 'maximal' ){
      add_action( 'admin_menu', array($this, 'add_settings_page') );
      add_action( 'admin_init', array($this, 'init_settings_page') );
    }
  }

  function init_options() {
    // Defaults
    if(!get_option(self::OPTION_CONFIG)) add_option( self::OPTION_CONFIG, '{}' );
  }

  // Insert MathJax script
  function insert_js_script() {
  	echo '<script type="text/x-mathjax-config">MathJax.Hub.Config('.get_option( self::OPTION_CONFIG ).');</script>';
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
    ?>
    <div class="wrap">
      <h2>MathJax</h2>
      <form method="post" action="options.php">
        <?php
        settings_fields( self::OPTION_GROUP );
        do_settings_sections( self::MENU_SLUG );
        submit_button('Save', 'primary', 'submit', false);
        ?>
        <input id="reset" class="button" type="reset" name="reset" value="Reset" style="margin: 0 0 0 10px;"/>
      </form>
    </div>
    <?php
  }

  function init_settings_page() {
    add_settings_section(
      'option_section', 
      '', 
      array($this, 'section_callback'), 
      self::MENU_SLUG
    );

    add_settings_field(
      self::OPTION_CONFIG,
      'Configuration',
      array( $this, 'setting_callback_config'),
      self::MENU_SLUG,
      'option_section'
    );

    register_setting( self::OPTION_GROUP, self::OPTION_CONFIG);
  }

  function section_callback() {
    ?>
    <p>Further to modify the defaults of MathJax.</p>
    <?php
  }

  function setting_callback_config() {
    ?>
    <textarea name="<?php echo self::OPTION_CONFIG ?>" rows="4" cols="50"><?php echo get_option( self::OPTION_CONFIG ); ?></textarea>
    <p>Give a json used as the configuration. For more info, refer to <a href="http://docs.mathjax.org/en/latest/configuration.html#using-in-line-configuration-options">using in-line configuration options</a>.</p>
    <p>Example 1</p>
    <textarea rows="10" cols="50" readonly>
{
    extensions: ["tex2jax.js"],
    jax: ["input/TeX", "output/HTML-CSS"],
    tex2jax: {
        inlineMath: [ ['$','$'], ["\\(","\\)"] ],
        displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
        processEscapes: true
    },
    "HTML-CSS": { availableFonts: ["TeX"] }
}</textarea>
    <p>Example 2</p>
    <textarea rows="5" cols="50" readonly>
{
    TeX: {
        extensions: ["mhchem.js"]
    }
}</textarea>
    <?php
  }

}

?>
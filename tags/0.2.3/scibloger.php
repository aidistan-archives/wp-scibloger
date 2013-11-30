<?php
/*

*******************************************************************************

Plugin Name: Science Blog Helper
Plugin URI: http://aidistan.github.io/aidi-wp-scibloger/
Description: A WordPress plugin for science blog writer.
Version: 0.2.3
Author: aidistan
Author URI: http://aidi.no-ip.org

*******************************************************************************

The MIT License (MIT)

Copyright (c) 2013 Aidi Stan

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*******************************************************************************

*/

class ScienceBlogHelper {

  // Constants
  const MENU_SLUG      = 'scibloger_page';

  const OPTION_GROUP   = 'scibloger_option_group';
  const OPTION_MODE    = 'scibloger_mode';
  const OPTION_MATHJAX = 'scibloger_mathjax';
  const OPTION_OUTLINE = 'scibloger_outline';

  // Member
  var $mMathJax;
  var $mOutline;

  function __construct() {

    // Init options
    $this -> init_options();

    // Load modules
    define('BASE_PATH', dirname(__FILE__));
    require BASE_PATH . '/mathjax.php';
    require BASE_PATH . '/outline.php';

    // Admin actions
    if ( is_admin() ){
      // Add settings link on plugin page
      add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_plugin_settings_link') );

      // Add settings menu and page
      add_action( 'admin_menu', array($this, 'add_plugin_settings_page') );
      add_action( 'admin_init', array($this, 'init_plugin_settings_page') );  
    }

    // Init modules
    $this -> mMathJax = new SciBloger_MathJax();
    $this -> mOutline = new SciBloger_Outline();
  }

  function init_options() {
    if(!get_option(self::OPTION_MODE))    add_option( self::OPTION_MODE, 'minimal' );
    if(!get_option(self::OPTION_MATHJAX)) add_option( self::OPTION_MATHJAX, 'on' );
    if(!get_option(self::OPTION_OUTLINE)) add_option( self::OPTION_OUTLINE, 'off' );
  }

  function add_plugin_settings_link($links) { 
    if(get_option( self::OPTION_MODE, 'minimal' ) == 'minimal')
      $settings_link = '<a href="options-general.php?page=' . self::MENU_SLUG . '">Settings</a>';   
    else
      $settings_link = '<a href="admin.php?page=' . self::MENU_SLUG . '">Settings</a>'; 
    
    array_unshift($links, $settings_link); 
    return $links; 
  }

  function add_plugin_settings_page() {
    if(get_option( self::OPTION_MODE, 'minimal' ) == 'minimal') {
      // Minimal
      add_options_page(
        'Science Blog Helper',
        'SciBloger',
        'manage_options',
        self::MENU_SLUG,
        array( $this, 'create_plugin_settings_page' )
      );
    } else {
      // Maximal
      add_utility_page(
        'Science Blog Helper',
        'SciBloger',
        'manage_options',
        self::MENU_SLUG,
        array( $this, 'create_plugin_settings_page' ),
        plugin_dir_url( __FILE__ ) . '/images/menu-icon.png'
      );
    }
  }

  function create_plugin_settings_page() {
    ?>
    <div class="wrap">
      <h2><b>Sci</b>ence <b>Blog</b> Help<b>er</b></h2>
      <form method="post" action="options.php">
        <?php
        settings_fields( self::OPTION_GROUP );
        do_settings_sections( self::MENU_SLUG );
        submit_button('Save', 'primary', 'submit', false);
        ?>
        <input type="reset" name="reset" id="reset" class="button button-primary" value="Reset" style="margin:10px 0 0 10px;"/>
      </form>
    </div>
    <?php
  }

  function init_plugin_settings_page() {
    add_settings_section(
      'option_section_main', 
      '', 
      array($this, 'section_callback_main'), 
      self::MENU_SLUG
    );
    
    add_settings_field(
      self::OPTION_MODE,
      'Configuration mode',
      array( $this, 'setting_callback_mode'),
      self::MENU_SLUG,
      'option_section_main'
    );

    add_settings_section(
      'option_section_mathjax', 
      'LaTeX Support', 
      array($this, 'section_callback_mathjax'), 
      self::MENU_SLUG
    );
    
    add_settings_field(
      self::OPTION_MODE,
      'MathJax engine',
      array( $this, 'setting_callback_mathjax'),
      self::MENU_SLUG,
      'option_section_mathjax'
    );

    add_settings_section(
      'option_section_outline', 
      'Outline Generation', 
      array($this, 'section_callback_outline'), 
      self::MENU_SLUG
    );
    
    add_settings_field(
      self::OPTION_OUTLINE,
      'Generate by default',
      array( $this, 'setting_callback_outline'),
      self::MENU_SLUG,
      'option_section_outline'
    );

    register_setting( self::OPTION_GROUP, self::OPTION_MODE );
    register_setting( self::OPTION_GROUP, self::OPTION_MATHJAX);
    register_setting( self::OPTION_GROUP, self::OPTION_OUTLINE);
  }

  function section_callback_main() {
    ?>
    Intended to help people build blogs on science and write more readable posts.
    <?php
  }

  function setting_callback_mode() {
    ?>
    <input name="<?php echo self::OPTION_MODE ?>" type="radio" value="minimal"
      <?php if(get_option( self::OPTION_MODE ) =='minimal') echo 'checked'; ?>
      > Minimal</input><br />
    <input name="<?php echo self::OPTION_MODE ?>" type="radio" value="maximal"
      <?php if(get_option( self::OPTION_MODE ) =='maximal') echo 'checked'; ?>
      > Maximal</input><br />

    For the greatest convenience, SciBloger follows "Convention over Configuration". 
    Least configs to make SciBloger work are shown in "Minimal" mode.
    To view and modify all settings, change to "Maximal" mode please.<br />
    <b>Notice</b>: Setting modified in maximal mode will still have effects in minimal mode.
    <?php
  }

  function section_callback_mathjax() {
    $this -> mMathJax -> insert_js_script();
    ?>
    MathJax is an open source JavaScript display engine for mathematics that works in all browsers. 
    Following are two simple demos. For more info, please visit MathJax <a href="http://www.mathjax.org/" target="_blank">Homepage</a> 
    or <a href="http://docs.mathjax.org/en/latest/" target="_blank">Documents</a>.
    <br/>
    <ol>
      <li><b>\<b></b>(...\<b></b>)</b> for in-line math: \( E = mc^2 \)</li>
      <li><b>\<b></b>[...\<b></b>]</b> or <b>$<b></b>$...$<b></b>$</b> for equations: $$ e^{\pi i} + 1 = 0 $$</li>
    </ol>
    <?php
  }

  function setting_callback_mathjax() {
    ?>
    <input name="<?php echo self::OPTION_MATHJAX ?>" type="radio" value="on"
      <?php if(get_option( self::OPTION_MATHJAX ) =='on') echo 'checked'; ?>
      > On</input><br />
    <input name="<?php echo self::OPTION_MATHJAX ?>" type="radio" value="off"
      <?php if(get_option( self::OPTION_MATHJAX ) =='off') echo 'checked'; ?>
      > Off</input><br />
    <?php
  }

  function section_callback_outline() {
    ?>
    Posts on science usually are long works. SciBloger's Outline will help you generate a useful outline as long as headers were set properly.
    In most wordpress themes, site titles are <i>h1</i> and post titles <i>h2</i>. It is highly recommended to make <b>h3</b> the top level in your post.
    Shortcodes are also supported to use Outline more flexible by overwritting the defaults: <br />
    <p style="text-align:center;">[scibloger_outline show="(yes/no, depends on your choose here)" right="10px" top="20%"]</p>
    <?php
  }

  function setting_callback_outline() {
    ?>
    <input name="<?php echo self::OPTION_OUTLINE ?>" type="radio" value="yes"
      <?php if(get_option( self::OPTION_OUTLINE ) =='yes') echo 'checked'; ?>
      > Yes</input><br />
    <input name="<?php echo self::OPTION_OUTLINE ?>" type="radio" value="no"
      <?php if(get_option( self::OPTION_OUTLINE ) =='no') echo 'checked'; ?>
      > No</input><br />
    <?php
  }
}

// Start this plugin once all other plugins are fully loaded
add_action( 'init', 'ScienceBlogHelper');
function ScienceBlogHelper() {
  $ScienceBlogHelper = new ScienceBlogHelper();
}

?>

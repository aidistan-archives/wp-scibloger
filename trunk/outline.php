<?php

class SciBloger_Outline {

  // Constants
  const MENU_TITLE = 'Outline';
  const PAGE_TITLE = 'SciBloger/Outline';
  const MENU_SLUG  = 'scibloger_outline_page';

  const OPTION_GROUP    = 'scibloger_outline_options';
  const OPTION_POSITION = 'scibloger_outline_position';
  const OPTION_THEME    = 'scibloger_outline_theme';

  var $mIsYes;
  var $mPosition;
  var $mIsSingle = false; // Only show on posts

  var $mOutline_content = "";
  var $mOutline_stack   = array();

  function __construct() {

    // Init options
    $this -> init_options();

    // Actions & filters by order
    add_action( 'wp', array($this, 'check_single') );
    add_action( 'wp_enqueue_scripts', array($this, 'register_style') );
    add_shortcode( 'scibloger_outline', array($this, 'parse_shortcode') );
    add_filter( 'the_content', array($this, 'add_header_anchors'), 500);
    add_action( 'wp_footer', array($this, 'add_outline') );

    if ( is_admin() && get_option( ScienceBlogHelper::OPTION_MODE ) == 'maximal' ){
      add_action( 'admin_menu', array($this, 'add_settings_page') );
      add_action( 'admin_init', array($this, 'init_settings_page') );  
    }
  }

  function init_options() {
    if(!get_option(self::OPTION_POSITION)) add_option( self::OPTION_POSITION, array("top"=>"20%", "right"=>"10px") );
    if(!get_option(self::OPTION_THEME)) add_option( self::OPTION_THEME, 'gray' );
  }

  function check_single() {
    if(is_single())
      $this -> mIsSingle = true;
  }

  function register_style() {
    $theme = get_option( self::OPTION_THEME );
    wp_register_style( 'scibloger_outline_basic', plugins_url( 'stylesheets/outline.css', __FILE__  ) );
    wp_register_style( 'scibloger_outline_theme', plugins_url( "stylesheets/outline_$theme.css", __FILE__  ), array('scibloger_outline_basic') );
  }

  function parse_shortcode( $atts ) {
    $this -> mPosition = get_option(self::OPTION_POSITION);
    $this -> mIsYes = get_option( ScienceBlogHelper::OPTION_OUTLINE );

    extract( shortcode_atts( array(
      'show'  => $this -> mIsYes,
      'right' => $this -> mPosition['right'],
      'top'=> $this -> mPosition['top']
    ), $atts ) );

    if (in_array($show, array('Yes','yes','Y','y','On','on','True','true','T','t')))
      $this -> mIsYes = true;
    else
      $this -> mIsYes = false;

    $this -> mPosition['right'] = $right;
    $this -> mPosition['top']   = $top;
    return "";
  }

  function add_header_anchors($content) {
    // Off
    if( !($this -> mIsSingle) || !($this -> mIsYes))
      return $content;

    // Main regexp
    preg_match_all('/<h(\d)[^>]*>(.*)<\/h\d>/isU', $content, $mat);
    if ( count($mat[0]) <= 1) {
      // If no more than one header
      return $content;
    } else {
      // Otherwise, need to create outline
      $list_items = array();
      array_push($this -> mOutline_stack, '2');
      for($i = 0; $i < count($mat[0]); $i++) {
        // Add list content
        array_push($list_items, 
          $this -> do_outline_stack($mat[1][$i], false) . 
          '<a href="#scibloger_outline_a'.$i.'">'.$mat[2][$i].'</a>');

        // Replace post content
        $content = str_replace($mat[0][$i], $mat[0][$i].'<a name="scibloger_outline_a'.$i.'"></a>', $content);
      }
      array_push($list_items, $this -> do_outline_stack('2', true));
      $this -> mOutline_content = join("\n", $list_items);
      return $content;
    }
  }

  function do_outline_stack($l, $isEnd) {
    $str = '';
    if(end($this -> mOutline_stack) < $l){
      $str .= '<ul class="l'.count($this -> mOutline_stack).'"><li>';
      array_push($this -> mOutline_stack, $l);
    } elseif (end($this -> mOutline_stack) == $l){
      if(!$isEnd)
        $str .= '</li><li>';
    } else {
      while(end($this -> mOutline_stack) > $l){
        $str .='</li></ul>';
        array_pop($this -> mOutline_stack);
      }
      $str .= $this -> do_outline_stack($l, $isEnd);
    }
    return $str;
  }

  function add_outline() {
    // Off or no need
    if( $this -> mOutline_content == "")
      return;

    // Load CSS styles
    wp_enqueue_style( 'scibloger_outline_basic' );
    wp_enqueue_style( 'scibloger_outline_theme' );

    // Main html codes
    extract($this -> mPosition);
    ?>
    <div id="scibloger_outline_wrapper" style="<?php echo "right:$right;top:$top;"; ?>">
      <div class="trigger">&lt;</div><?php echo $this -> mOutline_content; ?>
    </div>
    <?php
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
      <h2>Outline</h2>
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

  function init_settings_page() {
    add_settings_section(
      'option_section', 
      '', 
      array($this, 'section_callback'), 
      self::MENU_SLUG
    );

    add_settings_field(
      self::OPTION_POSITION,
      'Position',
      array( $this, 'setting_callback_position'),
      self::MENU_SLUG,
      'option_section'
    );

    add_settings_field(
      self::OPTION_THEME,
      'Theme',
      array( $this, 'setting_callback_theme'),
      self::MENU_SLUG,
      'option_section'
    );

    register_setting( self::OPTION_GROUP, self::OPTION_POSITION);
    register_setting( self::OPTION_GROUP, self::OPTION_THEME);
  }

  function section_callback() {
    ?>
    <p>Further to modify the defaults of Outline.</p>
    <?php
  }

  function setting_callback_position() {
    ?>
    <table><tbody><tr>
    <td style="margin:0;padding:0 20px 0 0;">Top</td>
    <td style="margin:0;padding:0 20px 0 0;">
      <input name="<?php echo self::OPTION_POSITION ?>[top]" type="text" style="width:50px;" value="<?php extract(get_option( self::OPTION_POSITION )); echo $top; ?>"><br />
    </td>
    <td style="margin:0;padding:0">(Default: 20%)</td></tr><tr>
    <td style="margin:0;padding:0;">Right</td>
    <td style="margin:0;padding:0;">
      <input name="<?php echo self::OPTION_POSITION ?>[right]" type="text" style="width:50px;" value="<?php extract(get_option( self::OPTION_POSITION )); echo $right; ?>"><br />
    </td>
    <td style="margin:0;padding:0;">(Default: 10px)</td>
    </tr></tbody></table>
    <p>Top and right margin between browser and the content.</p>
    <?php
  }

  function setting_callback_theme(){
    ?>
    <select name="<?php echo self::OPTION_THEME; ?>">
      <option value="gray"
        <?php if(get_option(self::OPTION_THEME)=='gray') echo 'selected'; ?>
        >Gray space</option>
      <option value="metro"
      <?php if(get_option(self::OPTION_THEME)=='metro') echo 'selected'; ?>
        >Metro era</option>
    </select>
    <?php
  }
}

?>

<?php

class SciBloger_Outline {

  // Constants
  const MENU_TITLE = 'Outline';
  const PAGE_TITLE = 'SciBloger/Outline';
  const MENU_SLUG  = 'scibloger_outline_page';

  var $mYes;
  var $mRight  ='10px';  
  var $mTop ='20%';

  var $mOutline_content = "";
  var $mOutline_stack   = array();

  function __construct() {
    // Global default
    $this -> mYes = (get_option( ScienceBlogHelper::OPTION_OUTLINE ) == 'yes');

    // Actions & filters by order
    add_action( 'wp', array($this, 'check_single') );
    add_action( 'wp_enqueue_scripts', array($this, 'register_style') );
    add_shortcode( 'scibloger_outline', array($this, 'parse_shortcode') );
    add_filter( 'the_content', array($this, 'add_header_anchors'), 500);
    add_action( 'wp_footer', array($this, 'add_outline') );
  }

  function check_single() {
    if(!is_single())
      $this -> mYes = 'no';
  }

  function register_style() {
    wp_register_style( 'scibloger_outline', plugins_url( 'aidi-wp-scibloger/outline.css' ), array(), false );
    wp_enqueue_style( 'scibloger_outline', array(), false );
  }

  function parse_shortcode( $atts ) {
    extract( shortcode_atts( array(
      'show'  => $this -> mYes,
      'right' => $this -> mRight,
      'top'=> $this -> mTop
    ), $atts ) );
    if (in_array($show, array('Yes','yes','Y','y','On','on','True','true','T','t')))
      $this -> mYes = "yes";
    else
      $this -> mYes = "no";
    $this -> mRight = $right;
    $this -> mTop  = $top;
    return "";
  }

  function add_header_anchors($content) {
    // Off
    if($this -> mYes != 'yes')
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

    ?>
    <div id="scibloger_outline_wrapper" style="right:<?php echo $this->mRight; ?>;top:<?php echo $this->mTop; ?>;">
      <div class="trigger">&lt;</div><?php echo $this -> mOutline_content; ?>
    </div>
    <?php
  }
}

?>

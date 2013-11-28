<?php

class SciBloger_Outline {

  // Constants
  const MENU_TITLE = 'Outline';
  const PAGE_TITLE = 'SciBloger/Outline';
  const MENU_SLUG  = 'scibloger_outline_page';

  var $outline_content = "";
  var $outline_stack   = array();

  function __construct() {
    if ( get_option( ScienceBlogHelper::OPTION_OUTLINE ) == 'on' )
      add_action( 'wp', array($this, 'init') );
  }

  function init() {
    if (is_single()) {
      add_action( 'wp_enqueue_scripts', array($this, 'register_style') );
      add_filter( 'the_content', array($this, 'add_content_anchors'), 500);
      add_action( 'wp_footer', array($this, 'add_outline') );
    }
  }

  function register_style() {
    wp_register_style( 'scibloger_outline', plugins_url( 'aidi-wp-scibloger/outline.css' ), array(), false );
    wp_enqueue_style( 'scibloger_outline', array(), false );
  }

  function add_content_anchors($content) {
    preg_match_all('/<h(\d)[^>]*>(.*)<\/h\d>/isU', $content, $mat);

    if ( count($mat[0]) <= 1) {
      // If no more than one header
      return $content;
    } else {
      // Otherwise, need to create outline
      $list_items = array();
      array_push($this -> outline_stack, '2');
      for($i = 0; $i < count($mat[0]); $i++) {
        // Add list content
        array_push($list_items, 
          $this -> do_outline_stack($mat[1][$i], false) . 
          '<a href="#scibloger_outline_a'.$i.'">'.$mat[2][$i].'</a>');

        // Replace post content
        $content = str_replace($mat[0][$i], $mat[0][$i].'<a name="scibloger_outline_a'.$i.'"></a>', $content);
      }
      array_push($list_items, $this -> do_outline_stack('2', true));

      $this -> outline_content = "\n<!-- SciBloger Outline start-->\n".join("\n", $list_items)."\n<!-- SciBloger Outline end-->\n";
      return $content;
    }
  }

  function do_outline_stack($l, $end_of_stack) {
    $str = '';
    if(end($this -> outline_stack) < $l){
      if(end($this -> outline_stack) == '2')
        $str .= '<ul class="root"><li>';
      else
        $str .= '<ul class="sub"><li>';
      array_push($this -> outline_stack, $l);
    } elseif (end($this -> outline_stack) == $l){
      $str .= '</li><li>';
    } else {
      while(end($this -> outline_stack) > $l){
        $str .='</li></ul>';
        array_pop($this -> outline_stack);
      }
      if(end($this -> outline_stack) < $l){
        $str .= '<ul class="sub"><li>';
        array_push($this -> outline_stack, $l);
      } elseif (end($this -> outline_stack) == $l){
        if(!$end_of_stack)
          $str .= '</li><li>';
      }
    }
    return $str;
  }

  function add_outline() {
    if( $this -> outline_content == "")
      return;

    ?>
    <div id="scibloger_outline_wrapper">
      <span><div class="trigger">&lt;</div></span>
      <span><div class="content"><?php echo $this -> outline_content; ?></div></span>
    </div>
    <?php
  }
}

?>
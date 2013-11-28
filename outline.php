<?php

class SciBloger_Outline {

  // Constants
  const MENU_TITLE = 'Outline';
  const PAGE_TITLE = 'SciBloger/Outline';
  const MENU_SLUG  = 'scibloger_outline_page';

  var $outline_content = "";

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
      $heads = array();
      for($i = 0; $i < count($mat[0]); $i++) {
        array_push($heads, '<a href="#scibloger_outline_a'.$i.'" class="scibloger_outline_h'.$mat[1][$i].'">'.$mat[2][$i].'</a><br />');
        $content = str_replace($mat[0][$i], $mat[0][$i].'<a name="scibloger_outline_a'.$i.'"></a>', $content);
      }
      $this -> outline_content = "\n<!-- SciBloger Outline start-->\n".join("\n", $heads)."\n<!-- SciBloger Outline end-->\n";
      return $content;
    }
  }

  function add_outline() {
    if( $this -> outline_content == "")
      return;

    ?>
    <div id="scibloger_outline_wrapper">
      <table><tr><td width="40px" style="vertical-align: bottom;">
        <div class="trigger">&lt;</div>
      </td><td>
        <div class="content"><?php echo $this -> outline_content; ?>
        </div>
      </td></tr></table>
    </div>
    <?php
  }
}

?>
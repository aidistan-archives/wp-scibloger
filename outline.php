<?php

class SciBloger_Outline {

  // Constants
  const MENU_TITLE = 'Outline';
  const PAGE_TITLE = 'SciBloger/Outline';
  const MENU_SLUG  = 'scibloger_outline_page';

  function __construct() {
    // Main function
    //if ( get_option( ScienceBlogHelper::OPTION_OUTLINE ) == 'on' )
    add_action( 'wp_head', array($this, 'insert_head' ), 10);
    add_action( 'get_sidebar', array($this, 'insert_outline'));
  }

  function insert_head() {
    ?>
    <style type="text/css">
      #scibloger_outline_trigger{
        position:fixed;
        padding: 20px;
        right: 0;
        top: 61.8%;
      }
      #scibloger_outline_box{
        position:fixed;
        padding: 20px;
        right: 0;
        top: 61.8%;
      }
    </style>
    <?php
  }

  function insert_outline() {
    ?>
    <dit id="scibloger_outline_trigger">
    </div>
    <div id="scibloger_outline_box" >
      Aidi is here.
    </div>
    <?php
  }
}

?>
jQuery(document).ready(function($) {
  $(document).ready(function(){
    
    // Show mainlist
    $("#scibloger_outline_wrapper .trigger").click(function() {
      $("#scibloger_outline_wrapper").addClass('pop');
    });

    $("#scibloger_outline_wrapper a").click(function() {
      var ul = $(this).parent().children('ul');
      if(ul.length && !ul.hasClass('pop')){
        // Show sublist
        ul.parent().parent().find('ul').removeClass('pop');
        ul.addClass('pop');
        return false;
      }
      // Hide all
      $("#scibloger_outline_wrapper ul").removeClass('pop');
      $("#scibloger_outline_wrapper").removeClass('pop');
    });
    
  });
});

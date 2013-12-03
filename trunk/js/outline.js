jQuery(document).ready(function($) {
  $(document).ready(function(){

    // Show mainlist
    $("#scibloger_outline_wrapper .trigger").hover(function() {
      $("#scibloger_outline_wrapper").addClass('pop');
    }, null);

    // Hide mainlist
    $("#scibloger_outline_wrapper").hover(null, function() {
      $(this).removeClass('pop');
    });

    // Show/Hide sublist
    $("#scibloger_outline_wrapper li").hover(function() {
      $(this).children('ul').addClass('pop');
    }, function() {
      $(this).children('ul').removeClass('pop');
    });

  });
});

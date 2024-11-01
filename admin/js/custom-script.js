jQuery(document).ready(function( $ ) {
    // Add Color Picker bacground of the notify
    $(function() {
        $('.woo-bg-notify').wpColorPicker();
        $(".woo-bg-notify").wpColorPicker(
  'option',
  'change',
  function(event, ui) {
    //button background change
     $(".woo-live-sale-pop-up").css( 'background-color', ui.color.toString());
  });
   }); 

      // Add Color Picker to the 
    $(function() {
        $('.woo-clr-notify').wpColorPicker();
        $(".woo-clr-notify").wpColorPicker(
  'option',
  'change',
  function(event, ui) {
    //button background change
     $(".woo-live-sale-pop-up").css( 'color', ui.color.toString());
  });
   }); 
          // Add Color Picker to the 
    $(function() {
        $('.woo-border-color-notify').wpColorPicker();
        $(".woo-border-color-notify").wpColorPicker(
  'option',
  'change',
  function(event, ui) {
    //button background change
     $(".woo-live-sale-pop-up").css( 'border-color', ui.color.toString());
  });
   }); 
console.log($('.wp-color-result-text').text());
});


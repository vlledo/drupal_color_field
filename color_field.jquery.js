/**
 * @file
 * Javascript for Color Field.
 */
(function ($) {
	Drupal.behaviors.color_field_default_widget = {
    attach: function(context) {
      $(".mc-custom-color-picker").empty().addColorPicker({
    	currentColor:Drupal.settings.color_field.value,
    	clickCallback: function(c) {
  		  $('#' + Drupal.settings.color_field.id).val(c);
  	    }
      });
    }
  }
})(jQuery);

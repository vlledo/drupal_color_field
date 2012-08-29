

/**
 * @file
 * Javascript for Field Example.
 */

/**
 * Provides a farbtastic colorpicker for the fancier widget.
 */

(function ($) {
	
  Drupal.behaviors.cck_colorpicker_default_widget = {
		  
    attach: function(context) {
	  
      $(".mc-custom-color-picker").empty().addColorPicker({
    	currentColor:Drupal.settings.mc_custom_color_field.value,
    	clickCallback: function(c) {
  		  $('#' + Drupal.settings.mc_custom_color_field.id).val(c);
  	    }
      });
    }
  }
  
})(jQuery);

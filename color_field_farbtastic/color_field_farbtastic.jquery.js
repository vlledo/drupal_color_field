/**
 * @file
 * Javascript for Color Field.
 */
(function ($) {
  Drupal.behaviors.color_field_farbtastic = {
    attach: function (context) {
	  $.each(Drupal.settings.color_field_farbtastic, function (selector) {
        console.log(selector);
        console.log(this.id);
        console.log(this.picker_id);
        $('#' + this.picker_id).farbtastic('#' + this.id);
	  });
    }
  };
})(jQuery);

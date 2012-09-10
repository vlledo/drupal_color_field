/**
 * @file
 * Javascript for Color Field.
 */
(function ($) {
  Drupal.behaviors.color_field = {
    attach: function (context) {
      $.each(Drupal.settings.color_field, function (selector) {
        console.log(this);
        $(selector).empty().addColorPicker({
          currentColor:this.value,
          colors:this.colors,
          clickCallback: function(c) {
            id = selector;
            id = id.replace("#div","edit");
            $('#' + id).val(c);
          }
        });
      });
    }
  };
})(jQuery);

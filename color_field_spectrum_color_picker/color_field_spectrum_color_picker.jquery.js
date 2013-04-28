/**
 * @file
 * Javascript for Color Field.
 */
(function ($) {
  Drupal.behaviors.color_field_spectrum = {
    attach: function (context) {
      $.each(Drupal.settings.color_field_spectrum, function (selector) {
        $('#' + this.id).spectrum({
          preferredFormat: "hex",
          showInput: this.show_input,
          showAlpha: this.show_alpha,
          /*className: this.class_name,
          showButtons: this.show_buttons,
          chooseText: this.choose_text,
          cancelText: this.cancel_text,
          showPalette: this.show_palette,
          palette: [this.palette]*/
        });
      });
    }
  };
})(jQuery);

/**
 * @file
 * Attaches behaviors for Drupal's color field.
 */

(function ($, Drupal) {

    'use strict';

    /**
     * Enables box widget on color elements.
     *
     * @type {Drupal~behavior}
     *
     * @prop {Drupal~behaviorAttach} attach
     *   Attaches a box widget to a color input element.
     */
    Drupal.behaviors.color_field = {
        attach: function (context, settings) {

            var $context = $(context);

            for(var unique_id in settings.color_field.color_field_widget_box.settings.default_colors) {
                var element_default_colors = settings.color_field.color_field_widget_box.settings.default_colors[unique_id];
                
                $context.find('#container-' + unique_id).each(function (index, element) {
                    var $element = $(element);
                    var $input = $element.prev().find('input');
                    $element.empty().addColorPicker({
                        currentColor: $input.val(),
                        colors: element_default_colors,
                        blotchClass:'color_field_widget_box__square',
                        blotchTransparentClass:'color_field_widget_box__square--transparent',
                        clickCallback: function(color) {
                            $input.val(color).trigger('change');
                        }
                    });
                });
            }
        },
    };

})(jQuery, Drupal);

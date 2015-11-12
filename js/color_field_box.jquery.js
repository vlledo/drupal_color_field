/**
 * @file
 * Attaches behaviors for Drupal's color field.
 */

(function (Drupal, drupalSettings) {

    "use strict";

    /**
     * Append active class.
     *
     * The link is only active if its path corresponds to the current path, the
     * language of the linked path is equal to the current language, and if the
     * query parameters of the link equal those of the current request, since the
     * same request with different query parameters may yield a different page
     * (e.g. pagers, exposed View filters).
     *
     * Does not discriminate based on element type, so allows you to set the active
     * class on any element: a, li…
     */
    Drupal.behaviors.color_field = {
        attach: function (context, settings) {
            console.log(context);
            console.log(settings);
            console.log(drupalSettings);

            // Start by finding all potentially active links.
            //var path = drupalSettings.path;
            //var queryString = JSON.stringify(path.currentQuery);
            //var querySelector = path.currentQuery ? "[data-drupal-link-query='" + queryString + "']" : ':not([data-drupal-link-query])';
            //var originalSelectors = ['[data-drupal-link-system-path="' + path.currentPath + '"]'];
            //var selectors;
        },
        detach: function (context, settings, trigger) {
        }
    };

})(Drupal, drupalSettings);
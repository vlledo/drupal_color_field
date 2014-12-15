<?php

/**
 * @file
 * Theme functions.
 */

/**
 * Formats a default color field widget.
 */
function theme_color_field_simple_widget($vars) {
  $element = $vars['element'];

  // Add library.
  drupal_add_library('color_field', 'jquery-simple-color');

  // Javascript settings.
  $settings = array();
  $settings['id'] = $element['rgb']['#id'];
  $settings['cell_width'] = (isset($field['settings']['cell_width']) && $field['settings']['cell_width'] != '') ? (int) $field['settings']['cell_width'] : 10;
  $settings['cell_height'] = (isset($field['settings']['cell_height']) && $field['settings']['cell_height'] != '') ? (int) $field['settings']['cell_height'] : 10;
  $settings['cell_margin'] = (isset($field['settings']['cell_margin']) && $field['settings']['cell_margin'] != '') ? (int) $field['settings']['cell_margin'] : 1;
  $settings['box_width'] = (isset($field['settings']['box_width']) && $field['settings']['box_width'] != '') ? $field['settings']['box_width'] . 'px' : '115px';
  $settings['box_height'] = (isset($field['settings']['box_height']) && $field['settings']['box_height'] != '') ? $field['settings']['box_height'] . 'px' : '20px';
  $settings['columns'] = (isset($field['settings']['columns']) && $field['settings']['columns'] != '') ? $field['settings']['columns'] : '16';

  // Attach javascript and style.
  $element['rgb']['#attached'] = array(
    'js' => array(
      drupal_get_path('module', 'color_field') . '/color_field_jquery_simple_color/color_field_jquery_simple_color.jquery.js',
      array(
        'data' => array('color_field_jquery_simple_color' => array('#' . $element['rgb']['#id'] => $settings)),
        'type' => 'setting',
      ),
    ),
    'css' => array(drupal_get_path('module', 'color_field') . '/color_field_jquery_simple_color/color_field_jquery_simple_color.css'),
  );

  $output = '';
  $output .= '<div class="link-field-subrow clearfix">';
  $output .= '<div class="link-field-title color-field-column">' . drupal_render($element['rgb']) . '</div>';

  if (isset($element['opacity'])) {
    $output .= '<div class="link-field-title color-field-column">' . drupal_render($element['opacity']) . '</div>';
  }

  $output .= '</div>';
  $output .= drupal_render_children($element);
  return $output;
}

/**
 * Formats a default color field widget.
 */
function theme_color_field_default_widget($vars) {
  $element = $vars['element'];

  // Javascript settings.
  $settings = array();
  $settings['id'] = $element['rgb']['#id'];
  $settings['divid'] = 'div-' . $element['rgb']['#id'];
  $settings['value'] = $element['#value']['rgb'];
  $default_colors = (isset($element['#settings']['default_colors'])) ? $element['#settings']['default_colors'] : '';
  preg_match_all("/#[0-9a-fA-F]{6}/", $default_colors, $default_colors, PREG_SET_ORDER);
  foreach ($default_colors as $color) {
    $settings['colors'][] = $color[0];
  }

  // Attach javascript and style.
  $element['rgb']['#attached'] = array(
    'js' => array(
      drupal_get_path('module', 'color_field') . '/color_field_default_widget/color_field.js',
      drupal_get_path('module', 'color_field') . '/color_field_default_widget/color_field.jquery.js',
      array(
        'data' => array('color_field' => array('#' . $settings['id'] => $settings)),
        'type' => 'setting',
      ),
    ),
    'css' => array(drupal_get_path('module', 'color_field') . '/color_field_default_widget/color_field.css'),
  );

  $element['rgb']['#suffix'] = '<label> ' . $element['rgb']['#title'] . ' </label><div id=div-' . $settings['id'] . '></div><div class="description">' . $element['rgb']['#description'] . '</div>';
  unset($element['rgb']['#title']);
  unset($element['rgb']['#description']);

  // Hide the input field.
  $element['rgb']['#attributes']['class'] = array('element-invisible');

  $output = '';
  $output .= '<div class="link-field-subrow clearfix">';
  $output .= '<div class="link-field-title color-field-column">' . drupal_render($element['rgb']) . '</div>';

  if (isset($element['opacity'])) {
    $output .= '<div class="link-field-title color-field-column">' . drupal_render($element['opacity']) . '</div>';
  }

  $output .= '</div>';
  $output .= drupal_render_children($element);
  return $output;
}

/**
 * Formats a plain color field widget.
 */
function theme_color_field_plain_text($vars) {
  drupal_add_css(drupal_get_path('module', 'color_field') . '/color_field_plain_text/color_field.css');
  $element = $vars['element'];
  $output = '';
  $output .= '<div class="link-field-subrow clearfix">';
  $output .= '<div class="link-field-title color-field-column">' . drupal_render($element['rgb']) . '</div>';
  if (isset($element['opacity'])) {
    $output .= '<div class="link-field-title color-field-column">' . drupal_render($element['opacity']) . '</div>';
  }
  $output .= '</div>';
  $output .= drupal_render_children($element);
  return $output;
}

/**
 * Formats a color swatch.
 */
function theme_color_swatch($variables) {
  $color = $variables['color'];
  $width = $variables['width'];
  $height = $variables['height'];
  return '<div class="color-swatch" style="background-color: ' . $color .  '; width: ' . $width . 'px; height: ' . $height . 'px;"></div>';
}

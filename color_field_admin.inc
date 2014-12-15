<?php

/**
 * @file
 * Date administration code.
 */

/**
 * Helper function for color_field_field_instance_settings_form().
 */
function _color_field_field_instance_settings_form($field, $instance) {
  $widget = $instance['widget'];
  $settings = $instance['settings'];

  $form = array();

  switch ($widget['type']) {
    case 'color_field_default_widget':
      $form['default_colors'] = array(
        '#type' => 'textarea',
        '#title' => t('Default colors'),
        '#default_value' => $settings['default_colors'],
        '#required' => TRUE,
        '#description' => t('Default colors for pre-selected color boxes'),
      );
      break;
    case 'color_field_simple_widget':
      $form['cell_width'] = array(
        '#type' => 'textfield',
        '#title' => t('Cell width'),
        '#default_value' => $settings['cell_width'],
        '#required' => TRUE,
        '#description' => t('Width of each individual color cell.'),
      );
      $form['cell_height'] = array(
        '#type' => 'textfield',
        '#title' => t('Height width'),
        '#default_value' => $settings['cell_height'],
        '#required' => TRUE,
        '#description' => t('Height of each individual color cell.'),
      );
      $form['cell_margin'] = array(
        '#type' => 'textfield',
        '#title' => t('Cell margin'),
        '#default_value' => $settings['cell_margin'],
        '#required' => TRUE,
        '#description' => t('Margin of each individual color cell.'),
      );
      $form['box_width'] = array(
        '#type' => 'textfield',
        '#title' => t('Box width'),
        '#default_value' => $settings['box_width'],
        '#required' => TRUE,
        '#description' => t('Width of the color display box.'),
      );
      $form['box_height'] = array(
        '#type' => 'textfield',
        '#title' => t('Box height'),
        '#default_value' => $settings['box_height'],
        '#required' => TRUE,
        '#description' => t('Height of the color display box.'),
      );
      $form['columns'] = array(
        '#type' => 'textfield',
        '#title' => t('Columns number'),
        '#default_value' => $settings['columns'],
        '#required' => TRUE,
        '#description' => t('Number of columns to display. Color order may look strange if this is altered.'),
      );
      break;
  }

  return $form;
}

/**
 * Helper function for color_field_field_settings_form().
 */
function _color_field_field_settings_form($field, $instance, $has_data) {
  $widget = $instance['widget'];

  $settings = $field['settings'];

  $form = array();

  $form['opacity'] = array(
    '#type' => 'checkbox',
    '#title' => t('Record opacity'),
    '#default_value' => $settings['opacity'],
    '#description' => t('If checked, the opacity will be recorded.'),
  );
  return $form;
}

/**
 * Helper function for color_field_field_settings_form().
 */
function _color_field_field_widget_form(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {
  // Current widget.
  $widget = $instance['widget'];

  // Default value.
  $default_value = isset($instance['default_value'][0]['rgb']) ? $instance['default_value'][0]['rgb'] : '';
  $default_opacity = isset($instance['default_value'][0]['opacity']) ? $instance['default_value'][0]['opacity'] : '';

  $value = isset($items[$delta]['rgb']) ? $items[$delta]['rgb'] : $default_value;
  $opacity = isset($items[$delta]['opacity']) ? $items[$delta]['opacity'] : $default_opacity;

  $element['rgb'] = array(
    '#type' => 'textfield',
    '#title' => t('Color'),
    '#description' => t('Format #FFFFFF'),
    '#default_value' => $value,
    '#size' => 7,
    '#maxlength' => 7,
  );

  if (isset($field['settings']['opacity']) && $field['settings']['opacity']) {
    $element['opacity'] = array(
      '#type' => 'textfield',
      '#title' => t('Opacity'),
      '#description' => t('Between 0 and 1'),
      '#default_value' => $opacity,
      '#size' => 4,
      '#maxlength' => 4,
    );
  }

  switch ($widget['type']) {
    case 'color_field_default_widgett':
      $element['rgb']['#type'] = 'token';
      break;
  }

  $element += array(
    '#settings' => $instance['settings'],
    '#type' => $widget['type'],
    '#default_value' => isset($items[$delta]) ? $items[$delta] : NULL,
  );
  return $element;
}

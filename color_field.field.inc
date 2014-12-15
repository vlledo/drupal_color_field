<?php

/**
 * @file
 * Field hooks to implement a color field.
 */

/**
 * Implements hook_field_info().
 */
function color_field_field_info() {
  return array(
    'color_field_rgb' => array(
      'label' => t('Color Field'),
      'description' => t('Field using a hexadecimal notation.'),
      // These settings apply to the color field field everywhere it is used.
      'settings' => array(
        'opacity' => FALSE,
      ),
      // These settings apply to the color field instance.
      'instance_settings' => array(
        'default_colors' => '
#AC725E,#D06B64,#F83A22,#FA573C,#FF7537,#FFAD46
#42D692,#16A765,#7BD148,#B3DC6C,#FBE983
#92E1C0,#9FE1E7,#9FC6E7,#4986E7,#9A9CFF
#B99AFF,#C2C2C2,#CABDBF,#CCA6AC,#F691B2
#CD74E6,#A47AE2',
        // Simple color.
        'cell_width' => 10,
        'cell_height' => 10,
        'cell_margin' => 1,
        'box_width' => 115,
        'box_height' => 20,
        'columns' => 16,
        // Spectrum.
        'show_input' => FALSE,
        'show_palette' => FALSE,
        'palette' => '',
        'show_palette_only' => TRUE,
        'show_buttons' => FALSE,
        'allow_empty' => FALSE,
      ),
      'default_widget' => 'color_field_default_widget',
      'default_formatter' => 'color_field_default_formatter',
      // @todo Support hook_entity_property_info() from contrib "Entity API".
      'property_type' => 'color_field_rgb',
    ),
  );
}

/**
 * Implements hook_field_validate().
 *
 * We want to verify that the items only contain RGB hex values like
 * this: #RRGGBB. If the item validates, we do nothing. If it doesn't
 * validate, we add our own error notification to the $errors parameter.
 *
 * @see color_field_widget_error()
 */
function color_field_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {
  foreach ($items as $delta => $item) {
    // Test rgb field.
    if (!empty($item['rgb'])) {
      if (!preg_match('@^#[0-9a-fA-F]{6}$@', $item['rgb'])) {
        $errors[$field['field_name']][$langcode][$delta][] = array(
          'error' => 'color_field_invalid',
          'message' => t('Color must be in the hexadecimal format #abcdef.'),
        );
      }
    }
    // Test opacity field.
    if (!empty($item['opacity']) && filter_var(
        $item['opacity'],
        FILTER_VALIDATE_FLOAT,
        array(
          'options' => array(
            'min_range' => 0,
            'max_range' => 1
          )
        )
      ) === false) {
        $errors[$field['field_name']][$langcode][$delta][] = array(
          'error' => 'color_field_invalid',
          'message' => t('Opacity need to be a float value'),
        );
      
    }
  }
}

/**
 * Implements hook_field_is_empty().
 */
function color_field_field_is_empty($item, $field) {
  if (!is_array($item)) {
    return FALSE;
  }
  if (empty($item['rgb'])) {
    return TRUE;
  }
  elseif ($field['settings']['opacity'] && empty($item['opacity'])) {
    return TRUE;
  }
  return FALSE;
}

/**
 * Implements hook_field_widget_error().
 *
 * @see color_field_validate()
 * @see form_error()
 */
function color_field_widget_error($element, $error, $form, &$form_state) {
  switch ($error['error']) {
    case 'color_field_invalid':
      form_error($element, $error['message']);
      break;
  }
}

/**
 * Implements hook_field_insert().
 */
function color_field_field_insert($entity_type, $entity, $field, $instance, $langcode, &$items) {
  foreach ($items as $delta => $value) {
    if (!isset($items[$delta]['opacity'])) {
      $items[$delta]['opacity'] = 1;
    }
  }
}

/**
 * Implements hook_field_update().
 */
function color_field_field_update($entity_type, $entity, $field, $instance, $langcode, &$items) {
  foreach ($items as $delta => $value) {
    if (!isset($items[$delta]['opacity'])) {
      $items[$delta]['opacity'] = 1;
    }
  }
}

/**
 * Implements hook_element_info().
 */
function color_field_element_info() {
  $elements = array();
  $elements['color_field_plain_text'] = array(
    '#input' => TRUE,
    '#theme' => 'color_field_plain_text',
    '#theme_wrappers' => array('form_element'),
  );
  $elements['color_field_default_widget'] = array(
    '#input' => TRUE,
    '#theme' => 'color_field_default_widget',
    '#theme_wrappers' => array('form_element'),
  );
  $elements['color_field_simple_widget'] = array(
    '#input' => TRUE,
    '#theme' => 'color_field_simple_widget',
    '#theme_wrappers' => array('form_element'),
  );
  $elements['color_field_spectrum_widget'] = array(
    '#input' => TRUE,
    '#theme' => 'color_field_spectrum_widget',
    '#theme_wrappers' => array('form_element'),
  );
  return $elements;
}

/**
 * Implements hook_field_widget_info().
 *
 * Enable the different field widgets.
 *
 * @see color_field_field_settings_form()
 * @see color_field_field_instance_settings_form
 * @see color_field_field_widget_form()
 */
function color_field_field_widget_info() {
  // If jquery-simple-color is enable so widget can be used.
  $jquery_simple_color_picker_enable = TRUE;
  $color_field_library_jquery_simple_color = drupal_get_library('color_field', 'jquery-simple-color');
  foreach ($color_field_library_jquery_simple_color['js'] as $path => $js) {
    if (!file_exists($path)) {
      $jquery_simple_color_picker_enable = FALSE;
    }
  }

  // If jquery_dematte_color_picker_enable is enable so widget can be used.
  $jquery_dematte_color_picker_enable = TRUE;
  $color_field_library_dematte_color = drupal_get_library('color_field', 'dematte-color-picker');
  foreach ($color_field_library_dematte_color['js'] as $path => $js) {
    if (!file_exists($path)) {
      $jquery_dematte_color_picker_enable = FALSE;
    }
  }

  // If jquery_eyecon_color_picker_enable is enable so widget can be used.
  $jquery_eyecon_color_picker_enable = TRUE;
  $color_field_library_eyecon_color = drupal_get_library('color_field', 'eyecon-color-picker');
  foreach ($color_field_library_eyecon_color['js'] as $path => $js) {
    if (!file_exists($path)) {
      $jquery_eyecon_color_picker_enable = FALSE;
    }
  }

  // If jquery_spectrum_color_picker_enable is enable so widget can be used.
  $jquery_spectrum_color_picker_enable = TRUE;
  $color_field_library_spectrum_color = drupal_get_library('color_field', 'bgrins-spectrum');
  foreach ($color_field_library_spectrum_color['js'] as $path => $js) {
    if (!file_exists($path)) {
      $jquery_spectrum_color_picker_enable = FALSE;
    }
  }
  foreach ($color_field_library_spectrum_color['css'] as $path => $js) {
    if (!file_exists($path)) {
      $jquery_spectrum_color_picker_enable = FALSE;
    }
  }

  $widgets = array();

  $widgets['color_field_default_widget'] = array(
    'label' => t('Pre-selected Color Boxes'),
    'field types' => array('color_field_rgb'),
  );

  // Color_field_farbtastic_widget need more work before release.
  /*$widgets['color_field_farbtastic_widget'] = array(
    'label' => t('Farbtastic Color-Picker'),
    'field types' => array('color_field_rgb'),
  );*/

  // Check if color_field_simple_color can become color_field_simple_widget
  if ($jquery_simple_color_picker_enable) {
    $widgets['color_field_simple_widget'] = array(
      'label' => t('Simple Color-Picker'),
      'field types' => array('color_field_rgb'),
    );
  }

  // Color_field_dematte_widget need more work before release.
  /*if ($jquery_dematte_color_picker_enable) {
    $widgets['color_field_dematte_widget'] = array(
      'label' => t('Dematte Color-Picker'),
      'field types' => array('color_field_rgb'),
    );
  }*/

  // color_field_eyecon_widget need more work before release.
  /*if ($jquery_eyecon_color_picker_enable) {
    $widgets['color_field_eyecon_widget'] = array(
      'label' => t('Eyecon Color-Picker'),
      'field types' => array('color_field_rgb'),
    );
  }*/

  // Dematte colorPicker.
  if ($jquery_spectrum_color_picker_enable) {
    $widgets['color_field_spectrum_widget'] = array(
      'label' => t('Spectrum Color-Picker'),
      'field types' => array('color_field_rgb'),
    );
  }

  // Textfield.
  $widgets['color_field_plain_text'] = array(
    'label' => t('Plain text (RGB value as #ffffff)'),
    'field types' => array('color_field_rgb'),
  );

  return $widgets;
}

/**
 * Implements hook_field_settings_form().
 */
function color_field_field_settings_form($field, $instance, $has_data) {
  module_load_include('inc', 'color_field', 'color_field_admin');
  return _color_field_field_settings_form($field, $instance, $has_data);
}

/**
 * Implements hook_field_instance_settings_form().
 */
function color_field_field_instance_settings_form($field, $instance) {
  module_load_include('inc', 'color_field', 'color_field_admin');
  return _color_field_field_instance_settings_form($field, $instance);
}

/**
 * Implements hook_field_widget_form().
 */
function color_field_field_widget_form(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {
  module_load_include('inc', 'color_field', 'color_field_admin');
  return _color_field_field_widget_form($form, $form_state, $field, $instance, $langcode, $items, $delta, $element);
}

/**
 * Implements hook_field_formatter_info().
 *
 * @see color_field_field_formatter_view()
 */
function color_field_field_formatter_info() {
  return array(
    'color_field_default_formatter' => array(
      'label' => t('Plain text color'),
      'field types' => array('color_field_rgb'),
    ),
    'color_field_css_declaration' => array(
      'label' => t('CSS Declaration'),
      'field types' => array('color_field_rgb'),
      'settings' => array(
        'selector' => 'body',
        'property' => 'background-color',
        'important' => TRUE,
      ),
    ),
    'color_field_swatch' => array(
      'label' => t('Color Swatch'),
      'field types' => array('color_field_rgb'),
      'settings' => array(
        'width' => '50',
        'height' => '50',
      ),
    ),
  );
}

/**
 * Implements hook_field_formatter_settings_form().
 */
function color_field_field_formatter_settings_form($field, $instance, $view_mode, $form, &$form_state) {
  $display = $instance['display'][$view_mode];
  $settings = $display['settings'];

  $element = array();

  switch ($display['type']) {
    case 'color_field_css_declaration':
      $element['selector'] = array(
        '#title' => t('Selector'),
        '#type' => 'textarea',
        '#default_value' => $settings['selector'],
        '#required' => TRUE,
        '#description' => t('A valid CSS selector such as <code>.links > li > a, #logo</code>.'),
      );
      $element['token'] = array(
        '#theme' => 'token_tree',
        '#token_types' => array($instance['entity_type']),
        '#dialog' => TRUE,
      );
      $element['property'] = array(
        '#title' => t('Property'),
        '#type' => 'select',
        '#default_value' => $settings['property'],
        '#required' => TRUE,
        '#options' => array(
          'background-color' => t('Background color'),
          'color' => t('Text color'),
        ),
      );
      $element['important'] = array(
        '#title' => t('Important'),
        '#type' => 'checkbox',
        '#default_value' => $settings['important'],
        '#description' => t('Whenever this declaration is more important than others.'),
      );
      break;

    case 'color_field_swatch':
      $element['width'] = array(
        '#title' => t('Width'),
        '#type' => 'textfield',
        '#default_value' => $settings['width'],
        '#required' => TRUE,
      );
      $element['height'] = array(
        '#title' => t('Height'),
        '#type' => 'textfield',
        '#default_value' => $settings['height'],
        '#required' => TRUE,
      );
      break;
  }

  return $element;

}

/**
 * Implements hook_field_formatter_settings_summary().
 */
function color_field_field_formatter_settings_summary($field, $instance, $view_mode) {
  $display = $instance['display'][$view_mode];
  $settings = $display['settings'];

  $summary = array();

  switch ($display['type']) {
    case 'color_field_css_declaration':
      $summary[] = t('CSS selector') . ': ' . $settings['selector'];
      $summary[] = t('CSS property') . ': ' . $settings['property'];
      $summary[] = t('!important declaration') . ': ' . (($settings['important']) ? t('Yes') : t('No'));
      break;

    case 'color_field_swatch':
      $summary[] = t('Width') . ': ' . $settings['width'];
      $summary[] = t('Height') . ': ' . $settings['height'];
      break;
  }

  return implode('<br />', $summary);
}

/**
 * Implements hook_field_formatter_view().
 *
 * Three formatters are implemented.
 * - color_field_default_formatter just outputs markup indicating the color that
 *   was entered and uses an inline style to set the text color to that value.
 * - color_field_css_declaration does the same but also changes the
 *   background color or color of a region defined by the selector.
 *
 * @see color_field_formatter_info()
 */
function color_field_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
  $element = array();
  $settings = $display['settings'];

  switch ($display['type']) {
    case 'color_field_default_formatter':
      foreach ($items as $delta => $item) {
        $element[$delta]['#markup'] = $item['rgb'];
      }
      break;

    case 'color_field_css_declaration':
      foreach ($items as $delta => $item) {
        $selector = token_replace($settings['selector'], array($entity_type => $entity), array('clear' => TRUE));
        $important = ($settings['important']) ? ' !important' : '';
        $inline_css = $settings['selector'] . '{' . $settings['property'] . ':' . $item['rgb'] . $important . '}';
        $inline_css = $selector . '{ ' . $settings['property'] . ': ' . $item['rgb'] . $important . '; }';
        drupal_add_css($inline_css, 'inline');
      }
      break;

    case 'color_field_swatch':
      foreach ($items as $delta => $item) {
        $rgb = $item['rgb'];
        $opacity = $item['opacity'];
        $width = $settings['width'];
        $height = $settings['height'];

        $element[$delta] = array(
          '#theme' => 'color_swatch',
          '#color' => $rgb,
          '#width' => $width,
          '#height' => $height,
        );
      }
      break;
  }

  return $element;
}

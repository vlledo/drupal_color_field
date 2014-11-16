<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldFormatter\ColorFieldTextFormatter.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_field_swatch' formatter.
 *
 * @FieldFormatter(
 *   id = "color_field_text",
 *   module = "color_field",
 *   label = @Translation("Color Text"),
 *   field_types = {
 *     "color_field",
 *   }
 * )
 */
class ColorFieldTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'format' => 'hexadecimal',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['format'] = array(
      '#type' => 'select',
      '#title' => t('Format'),
      '#options' => $this->getColorFormat(),
      '#default_value' => $this->getSetting('format'),
    );

    return $elements;
  }


  public function getColorFormat($format = NULL) {
    $formats = array();
    $formats['hexadecimal'] = $this->t('Hexadecimal Colors');
    $formats['rgb'] = $this->t('RGB Colors');
    $formats['rgba'] = $this->t('RGBA Colors');
    // $formats['hsl'] = $this->t('HSL Colors');
    // $formats['hsla'] = $this->t('HSLA Colors');
    if ($format) {
      return $formats[$format];
    }
    return $formats;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $format = $this->getSetting('format');

    $summary[] = t('Format: @format', array(
      '@format' => $this->getColorFormat($format),
    ));

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $format = $this->getSetting('format');
    $opacity = $this->getFieldSetting('opacity');

    foreach ($items as $delta => $item) {
      switch ($format) {
        case 'hexadecimal':
          $output = '#' . $item->color;
          break;
        case 'rgb':
          $color = color_field_hex2rgb($item->color);
          $output = 'rgb(' . $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ')';
          break;
        case 'rgba':
          $color = color_field_hex2rgb($item->color);
          $item->opacity = ($opacity) ? $item->color : 1;
          $output = 'rgb(' . $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $item->color . ')';
          break;
        //case 'hsl':
        //  $output = 'hsl(120,100%,50%)';
        //  break;
        //case 'hsla':
        //  $output = 'hsla(120,100%,50%,0.3)';
        //  break;
      }
      $elements[$delta] = array('#markup' => $output);
    }
    return $elements;
  }

}

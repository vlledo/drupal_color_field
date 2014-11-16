<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldFormatter\ColorFieldSwatchFormatter.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_field_swatch' formatter.
 *
 * @FieldFormatter(
 *   id = "color_field_swatch",
 *   module = "color_field",
 *   label = @Translation("Color Swatch"),
 *   field_types = {
 *     "color_field",
 *   }
 * )
 */
class ColorFieldSwatchFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'width' => 50,
      'height' => 50,
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['width'] = array(
      '#type' => 'number',
      '#title' => t('Width'),
      '#default_value' => $this->getSetting('width'),
      '#min' => 1,
      '#description' => t(''),
    );
    $elements['height'] = array(
      '#type' => 'number',
      '#title' => t('Height'),
      '#default_value' => $this->getSetting('height'),
      '#min' => 1,
      '#description' => t(''),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $settings = $this->getSettings();

    $summary[] = t('Width: @width Height: @height', array(
      '@width' => $settings['width'],
      '@height' => $settings['height']
    ));

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();
    $settings = $this->getSettings();
    $opacity = $this->getFieldSetting('opacity');

    foreach ($items as $delta => $item) {
      $color = color_field_hex2rgb($item->color);
      if ($opacity) {
        $rgbtext = 'rgba(' . $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ',' . $item->opacity . ')';
      }
      else {
        $rgbtext = 'rgb(' . $color['r'] . ',' . $color['g'] . ',' . $color['b'] . ')';
      }
      $elements[$delta] = array(
        '#markup' => '<div style="background-color: ' . $rgbtext . '; width: ' . $settings['width'] . 'px; height: ' . $settings['height'] . 'px;"></div>',
      );
    }

    return $elements;
  }

}

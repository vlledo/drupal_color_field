<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldFormatter\ColorFormatterSwatch.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\color_field\ColorHex;

/**
 * Plugin implementation of the 'color_field_swatch' formatter.
 *
 * @FieldFormatter(
 *   id = "color_formatter_swatch",
 *   module = "color_field",
 *   label = @Translation("Color Swatch"),
 *   field_types = {
 *     "color_type"
 *   }
 * )
 */
class ColorFormatterSwatch extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'shape' => 'square',
      'width' => 50,
      'height' => 50,
      'opacity' => TRUE,
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $opacity = $this->getFieldSetting('opacity');

    $elements = [];

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

    if ($opacity) {
      $elements['opacity'] = array(
        '#type' => 'checkbox',
        '#title' => t('Display opacity'),
        '#default_value' => $this->getSetting('opacity'),
      );
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $opacity = $this->getFieldSetting('opacity');
    $settings = $this->getSettings();

    $summary = [];

    $summary[] = t('Width: @width Height: @height', array(
      '@width' => $settings['width'],
      '@height' => $settings['height']
    ));

    if ($opacity && $settings['opacity']) {
      $summary[] = t('Display with opacity.');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $settings = $this->getSettings();

    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#theme' => 'color_field_swatch',
        '#color' => $this->viewValue($item),
        '#width' => $settings['width'],
        '#height' => $settings['height'],
      );
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The background color generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    $opacity = $this->getFieldSetting('opacity');
    $settings = $this->getSettings();

    $color_hex = new ColorHex($item->color, $item->opacity);

    if ($opacity && $settings['opacity']) {
      $rgbtext = $color_hex->toRGB()->toString(TRUE);
    } else {
      $rgbtext = $color_hex->toRGB()->toString(FALSE);
    }

    return $rgbtext;
  }

}

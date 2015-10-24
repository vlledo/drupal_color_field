<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldFormatter\ColorFormatterText.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\color_field\ColorHex;

/**
 * Plugin implementation of the 'color_formatter_text' formatter.
 *
 * @FieldFormatter(
 *   id = "color_formatter_text",
 *   module = "color_field",
 *   label = @Translation("Color Text"),
 *   field_types = {
 *     "color_type"
 *   }
 * )
 */
class ColorFormatterText extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'format' => 'hex',
      'opacity' => TRUE,
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $opacity = $this->getFieldSetting('opacity');

    $elements = [];

    $elements['format'] = array(
      '#type' => 'select',
      '#title' => t('Format'),
      '#options' => $this->getColorFormat(),
      '#default_value' => $this->getSetting('format'),
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
   * @param string $format
   * @return array|string
   */
  protected function getColorFormat($format = NULL) {
    $formats = [];
    $formats['hex'] = $this->t('Hex triplet');
    $formats['rgb'] = $this->t('RGB Decimal');

    if ($format) {
      return $formats[$format];
    }
    return $formats;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $opacity = $this->getFieldSetting('opacity');
    $settings = $this->getSettings();

    $summary = [];

    $summary[] = t('@format', array(
      '@format' => $this->getColorFormat($settings['format']),
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
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
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
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    $opacity = $this->getFieldSetting('opacity');
    $settings = $this->getSettings();

    $color_hex = new ColorHex($item->color, $item->opacity);

    switch ($settings['format']) {
      case 'hex':
        $output = $color_hex->toString(FALSE);
        if ($opacity && $settings['opacity']) {
          $output = $color_hex->toString(TRUE);
        }
        break;

      case 'rgb':
        $output = $color_hex->toRGB()->toString(FALSE);
        if ($opacity && $settings['opacity']) {
          $output = $color_hex->toRGB()->toString(FALSE);
        }
        break;
    }

    return $output;
  }

}

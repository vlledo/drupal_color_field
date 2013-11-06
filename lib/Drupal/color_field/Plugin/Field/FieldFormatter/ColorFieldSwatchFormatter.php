<?php

/**
 * @file
 * Definition of Drupal\color_field\Plugin\Field\FieldFormatter\ColorFieldSwatchFormatter.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'color_field_swatch' formatter.
 *
 * @FieldFormatter(
 *   id = "color_field_swatch",
 *   module = "color_field",
 *   label = @Translation("Color Swatch"),
 *   field_types = {
 *     "color_field",
 *   },
 *   settings = {
 *     "width" = "50",
 *     "height" = "50",
 *   }
 * )
 */
class ColorFieldSwatchFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $settings = $this->getSettings();

    $summary[] = t('Width: @width Height: @height px', array(
      '@width' => $settings['width'],
      '@height' => $settings['height']
    ));

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $elements = parent::settingsForm($form, $form_state);

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
  public function viewElements(EntityInterface $entity, $langcode, array $items) {
    $elements = array();
    $settings = $this->getSettings();

    foreach ($items as $delta => $item) {
      $elements[$delta] = array('#markup' => '<div style="background: ' . $item['rgb'] . '; width: ' . $settings['width'] . 'px; height: ' . $settings['height'] . 'px;"></div>');
    }

    return $elements;
  }

}

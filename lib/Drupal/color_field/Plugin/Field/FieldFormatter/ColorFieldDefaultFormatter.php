<?php

/**
 * @file
 * Contains \Drupal\color_field\Plugin\Field\FieldFormatter\ColorFieldDefaultFormatter.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'color_field_default' formatter.
 *
 * @FieldFormatter(
 *   id = "color_field_default",
 *   module = "color_field",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "color_field"
 *   }
 * )
 */
class ColorFieldDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $elements = array();
    $settings = $this->getFieldSettings();
    $alfa = $this->getSetting('alfa');

    foreach ($items as $delta => $item) {
      $output = $item->value;

      $elements[$delta] = array('#markup' => $output);
    }

    return $elements;
  }

}

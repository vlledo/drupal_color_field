<?php

/**
 * @file
 * Definition of Drupal\color_field\Plugin\Field\FieldFormatter\ColorFieldDefaultFormatter.
 */

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'color_field_default' formatter.
 *
 * @FieldFormatter(
 *   id = "color_field_default",
 *   module = "color_field",
 *   label = @Translation("Color Hex Formatter"),
 *   field_types = {
 *     "color_field"
 *   }
 * )
 */
class ColorFieldDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(EntityInterface $entity, $langcode, array $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      // The text value has no text format assigned to it, so the user input
      // should equal the output, including newlines.
      $elements[$delta] = array('#markup' => $item['rgb']);
    }

    return $elements;
  }

}

<?php

/**
 * @file
 * Contains \Drupal\color_field\Plugin\field\formatter\ColorFieldHexFormatter.
 */

namespace Drupal\color_field\Plugin\field\formatter;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;
use Drupal\field\Plugin\Type\Formatter\FormatterBase;
use Drupal\Core\Entity\EntityInterface;

/**
 * Plugin implementation of the 'color_field_hex' formatter.
 *
 * @Plugin(
 *   id = "color_field_default",
 *   module = "color_field",
 *   label = @Translation("Color HEX"),
 *   field_types = {
 *     "color_field"
 *   }
 * )
 */
class ColorFieldHexFormatter extends FormatterBase {

  /**
   * Implements Drupal\field\Plugin\Type\Formatter\FormatterInterface::viewElements().
   */
  public function viewElements(EntityInterface $entity, $langcode, array $items) {
    $elements = array();

    foreach ($items as $delta => $item) {
      $elements[$delta] = array(
        '#type' => 'link',
        '#title' => $item['value'],
        '#href' => 'mailto:' . $item['value'],
      );
    }

    return $elements;
  }

}

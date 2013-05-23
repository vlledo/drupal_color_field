<?php

/**
 * @file
 * Contains \Drupal\color_field\Plugin\field\widget\ColorFieldDefaultWidget.
 */

namespace Drupal\color_field\Plugin\field\widget;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;
use Drupal\field\Plugin\Type\Widget\WidgetBase;

/**
 * Plugin implementation of the 'color_field_default' widget.
 *
 * @Plugin(
 *   id = "color_field_default",
 *   module = "color_field",
 *   label = @Translation("Color field"),
 *   field_types = {
 *     "color_field"
 *   },
 *   settings = {
 *     "placeholder_title" = ""
 *   }
 * )
 */
class ColorFieldDefaultWidget extends WidgetBase {

  /**
   * Implements \Drupal\field\Plugin\Type\Widget\WidgetInterface::formElement().
   */
  public function formElement(array $items, $delta, array $element, $langcode, array &$form, array &$form_state) {
    $element['value'] = $element + array(
      '#type' => 'textfield',
      '#maxlength' => 6,
      '#title' => t('Color Field'),
      '#default_value' => isset($items[$delta]['value']) ? $items[$delta]['value'] : NULL,
      '#placeholder' => $this->getSetting('placeholder'),
      '#required' => $element['#required'],
    );
    return $element;
  }

  /**
   * Implements Drupal\field\Plugin\Type\Widget\WidgetInterface::settingsForm().
   */
  public function settingsForm(array $form, array &$form_state) {
    $element['placeholder'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );
    return $element;
  }

}

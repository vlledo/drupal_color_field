<?php

/**
 * @file
 * Contains \Drupal\color_field\Plugin\Field\FieldWidget\ColorFieldDefaultWidget.
 */

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Plugin implementation of the 'color_field_default' widget.
 *
 * @FieldWidget(
 *   id = "color_field_default",
 *   module = "color_field",
 *   label = @Translation("Color field default"),
 *   field_types = {
 *     "color_field"
 *   },
 *   settings = {
 *     "placeholder" = ""
 *   }
 * )
 */
class ColorFieldDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
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

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $placeholder = $this->getSetting('placeholder');
    if (!empty($placeholder)) {
      $summary[] = t('Placeholder: @placeholder', array('@placeholder' => $placeholder));
    }
    else {
      $summary[] = t('No placeholder');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, array &$form_state) {
    $element['rgb'] = array(
      '#title' => t('Color Field'),
      '#type' => 'textfield',
      '#maxlength' => 7,
      '#size' => 7,
      '#required' => $element['#required'],
      '#default_value' => isset($items[$delta]->rgb) ? $items[$delta]->rgb : NULL,
    );
    if ($this->getFieldSetting('alfa')) {
      $element['rgb']['#prefix'] = '<div class="container-inline">';

      $element['alfa'] = array(
        '#title' => t('Alfa'),
        '#type' => 'textfield',
        '#maxlength' => 3,
        '#size' => 3,
        '#required' => $element['#required'],
        '#default_value' => isset($items[$delta]->alfa) ? $items[$delta]->alfa : NULL,
        '#suffix' => '</div>',
      );
    }
    return $element;
  }

}

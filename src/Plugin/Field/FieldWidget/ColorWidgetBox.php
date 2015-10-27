<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldWidget\ColorWidgetBox.
 */

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_field_default' widget.
 *
 * @FieldWidget(
 *   id = "color_widget_box",
 *   module = "color_field",
 *   label = @Translation("Color boxes"),
 *   field_types = {
 *     "color_type"
 *   }
 * )
 */
class ColorWidgetBox extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'default_colors' => '
#AC725E,#D06B64,#F83A22,#FA573C,#FF7537,#FFAD46
#42D692,#16A765,#7BD148,#B3DC6C,#FBE983
#92E1C0,#9FE1E7,#9FC6E7,#4986E7,#9A9CFF
#B99AFF,#C2C2C2,#CABDBF,#CCA6AC,#F691B2
#CD74E6,#A47AE2',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['default_colors'] = array(
      '#type' => 'textarea',
      '#title' => t('Default colors'),
      '#default_value' => $this->getSetting('default_colors'),
      '#required' => TRUE,
      '#description' => t('Default colors for pre-selected color boxes'),
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $default_colors = $this->getSetting('default_colors');

    if (!empty($default_colors)) {
      preg_match_all("/#[0-9a-fA-F]{6}/", $default_colors, $default_colors, PREG_SET_ORDER);
      foreach ($default_colors as $color) {
        $colors = $color[0];
        $summary[] = $colors;
      }
    }

    if (empty($summary)) {
      $summary[] = t('No default colors');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];

    $element['#title'] = $this->fieldDefinition->getLabel();;
    $element['#description'] = $this->fieldDefinition->getDescription();
    $element['#required'] = TRUE;

    $element['#attributes']['class'][] = 'container-inline';
    $element['#theme_wrappers'] = array('color_widget_box');

    $element['#attached']['library'][] = 'color_field/color-field-box';
    $element['drupalSettings']['color_field']['color_widget_box']['settings'] = $this->getSettings();

    $element['color'] = array(
      '#maxlength' => 7,
      '#size' => 7,
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->color) ? $items[$delta]->color : NULL,
    );

    if ($this->getFieldSetting('opacity')) {
      $element['opacity'] = array(
        '#title' => t('Opacity'),
        '#type' => 'textfield',
        '#maxlength' => 3,
        '#size' => 3,
        '#default_value' => isset($items[$delta]->opacity) ? $items[$delta]->opacity : NULL,
        '#placeholder' => $this->getSetting('placeholder_opacity'),
      );
    }

    return $element;
  }

}

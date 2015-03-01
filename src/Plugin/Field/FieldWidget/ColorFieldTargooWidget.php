<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldWidget\ColorFieldTargooWidget.
 */

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_field_default' widget.
 *
 * @FieldWidget(
 *   id = "color_field_targoo",
 *   module = "color_field",
 *   label = @Translation("Color field Targoo"),
 *   field_types = {
 *     "color_field"
 *   }
 * )
 */
class ColorFieldTargooWidget extends WidgetBase {

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
    $summary = array();

    $colors = array();
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
    $element['color'] = array(
      '#title' => t('Color'),
      '#type' => 'textfield',
      '#maxlength' => 6,
      '#size' => 6,
      '#required' => $element['#required'],
      '#default_value' => isset($items[$delta]->color) ? $items[$delta]->color : NULL,
    );

    if ($this->getFieldSetting('opacity')) {
      $element['color']['#prefix'] = '<div class="container-inline">';

      $element['opacity'] = array(
        '#title' => t('Opacity'),
        '#type' => 'textfield',
        '#maxlength' => 3,
        '#size' => 3,
        '#required' => $element['#required'],
        '#default_value' => isset($items[$delta]->opacity) ? $items[$delta]->opacity : NULL,
        '#suffix' => '</div>',
      );
    }

    // Attach library containing css and js files.
    $element['#attached']['library'][] = 'color_field/simpleWidget';
    $element['#attached']['drupalSettings']['color_field_targoo']['settings'] = $this->getSettings();

    return $element;
  }

}

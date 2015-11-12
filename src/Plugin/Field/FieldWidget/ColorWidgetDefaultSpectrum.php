<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldWidget\ColorFieldSpectrumWidget.
 */

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'color_field_default' widget.
 *
 * @FieldWidget(
 *   id = "color_field_spectrum",
 *   module = "color_field",
 *   label = @Translation("Color field Spectrum"),
 *   field_types = {
 *     "color_field"
 *   }
 * )
 */
class ColorFieldSpectrumWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'show_input' => FALSE,
      'show_palette' => FALSE,
      'palette' => '',
      'show_palette_only' => TRUE,
      'show_buttons' => FALSE,
      'allow_empty' => FALSE,
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['show_input'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show Input'),
      '#default_value' => $this->getSetting('show_input'),
      '#description' => t('Allow free form typing.'),
    );
    $element['show_palette'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show Palette'),
      '#default_value' => $this->getSetting('show_palette'),
      '#description' => t('Show or hide Palette in Spectrum Widget'),
    );
    $element['palette'] = array(
      '#type' => 'textarea',
      '#title' => t('Color Palette'),
      '#default_value' => $this->getSetting('palette'),
      '#description' => t('Selectable color palette to accompany the Spectrum Widget'),
      '#states' => array(
        'visible' => array(
          ':input[name="field[settings][show_palette]"]' => array('checked' => TRUE),
        ),
      ),
    );
    $element['show_palette_only'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show Palette Only'),
      '#default_value' => $this->getSetting('show_palette_only'),
      '#description' => t('Only show thePalette in Spectrum Widget and nothing else'),
    );
    $element['show_buttons'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show Buttons'),
      '#default_value' => $this->getSetting('show_buttons'),
      '#description' => t('Add Cancel/Confirm Button.'),
    );
    $element['allow_empty'] = array(
      '#type' => 'checkbox',
      '#title' => t('Allow Empty'),
      '#default_value' => $this->getSetting('allow_empty'),
      '#description' => t('Allow empty value.'),
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $placeholder_color = $this->getSetting('placeholder_color');
    $placeholder_opacity = $this->getSetting('placeholder_opacity');

    if (!empty($placeholder_color)) {
      $summary[] = t('Color placeholder: @placeholder_color', array('@placeholder_color' => $placeholder_color));
    }

    if (!empty($placeholder_opacity)) {
      $summary[] = t('Opacity placeholder: @placeholder_opacity', array('@placeholder_opacity' => $placeholder_opacity));
    }

    if (empty($summary)) {
      $summary[] = t('No placeholder');
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

    return $element;
  }

}

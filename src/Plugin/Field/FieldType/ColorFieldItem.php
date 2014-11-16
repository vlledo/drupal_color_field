<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldType\ColorFieldItem.
 */

namespace Drupal\color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'color_field' field type.
 *
 * @FieldType(
 *   id = "color_field",
 *   label = @Translation("Color"),
 *   description = @Translation("Create and store Color value."),
 *   default_widget = "color_field_default",
 *   default_formatter = "color_field_text"
 * )
 */
class ColorFieldItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'color' => array(
          'description' => 'The RGB hex values',
          'type' => 'varchar',
          'length' => 7,
          'not null' => FALSE,
        ),
        'opacity' => array(
          'description' => 'The opacity/alphavalue property',
          'type' => 'float',
          'size' => 'tiny',
          'not null' => FALSE,
        ),
      ),
      'indexes' => array(
        'color' => array('color'),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['color'] = DataDefinition::create('string')
      ->setLabel(t('Color'));

    $properties['opacity'] = DataDefinition::create('float')
      ->setLabel(t('Opacity'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('color')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = array();

    $element['opacity'] = array(
      '#type' => 'checkbox',
      '#title' => t('Record opacity'),
      '#default_value' => $this->getSetting('opacity'),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    return '';
  }

}

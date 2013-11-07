<?php

/**
 * @file
 * Contains \Drupal\color_field\Plugin\Field\FieldType\ColorFieldItem.
 */

namespace Drupal\color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\ConfigFieldItemBase;
use Drupal\field\FieldInterface;

/**
 * Plugin implementation of the 'color_field' field type.
 *
 * @FieldType(
 *   id = "color_field",
 *   label = @Translation("Color Field"),
 *   description = @Translation("Create and store Color value."),
 *   default_widget = "color_field_default",
 *   default_formatter = "color_field_default"
 * )
 */
class ColorFieldItem extends ConfigFieldItemBase {

  /**
   * {@inheritdoc}
   */
  static $propertyDefinitions;

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldInterface $field) {
    return array(
      'columns' => array(
        'rgb' => array(
          'description' => 'The 7-character value',
          'type' => 'varchar',
          'length' => 7,
          'not null' => FALSE,
        ),
        'alfa' => array(
          'description' => 'The alfa value',
          'type' => 'float',
          'size' => 'tiny',
          'not null' => FALSE,
        ),
      ),
      'indexes' => array(
        'rgb' => array('rgb'),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions() {
    if (!isset(static::$propertyDefinitions)) {
      static::$propertyDefinitions['rgb'] = array(
        'type' => 'string',
        'label' => t('HEX Color value'),
      );
      static::$propertyDefinitions['alfa'] = array(
        'type' => 'float',
        'label' => t('Alfa value'),
      );
    }
    return static::$propertyDefinitions;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('rgb')->getValue();
    return $value === NULL || $value === '';
  }
}

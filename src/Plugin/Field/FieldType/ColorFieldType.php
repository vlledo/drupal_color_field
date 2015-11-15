<?php

/**
 * @file
 * Contains Drupal\color_field\Plugin\Field\FieldType\ColorFieldType.
 */

namespace Drupal\color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslationWrapper;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'color_type' field type.
 *
 * @FieldType(
 *   id = "color_field_type",
 *   label = @Translation("Color"),
 *   description = @Translation("Create and store color value."),
 *   default_widget = "color_field_widget_default",
 *   default_formatter = "color_field_formatter_text"
 * )
 */
class ColorFieldType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return array(
      'opacity' => TRUE,
    ) + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return array(
      'format' => '#HEXHEX',
    ) + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $element = [];

    $element['format'] = array(
      '#type' => 'select',
      '#title' => t('Format storage'),
      '#description' => t('Choose how to store the color.'),
      '#default_value' => $this->getSetting('format'),
      '#options' => array(
        '#HEXHEX' => t('#123ABC'),
        'HEXHEX' => t('123ABC'),
        '#hexhex' => t('#123abc'),
        'hexhex' => t('123abc'),
      ),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = [];

    $element['opacity'] = array(
      '#type' => 'checkbox',
      '#title' => t('Record opacity'),
      '#description' => t('Whether or not to record.'),
      '#default_value' => $this->getSetting('opacity'),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    //$format = $field_definition->getSetting('format');
    //$color_length = isset($format) ? strlen($format) : 7 ;
    $color_length = 7;
    return array(
      'columns' => array(
        'color' => array(
          'description' => 'The color value',
          'type' => 'varchar',
          'length' => $color_length,
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
    // Prevent early t() calls by using the TranslationWrapper.
    $properties['color'] = DataDefinition::create('string')
      ->setLabel(new TranslationWrapper('Color'));
    // ->setSetting('case_sensitive', $field_definition->getSetting('case_sensitive'))
    // ->setRequired(TRUE);

    $properties['opacity'] = DataDefinition::create('float')
      ->setLabel(new TranslationWrapper('Opacity'));
    // ->setSetting('case_sensitive', $field_definition->getSetting('case_sensitive'))
    // ->setRequired(TRUE);

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
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();

    if ($format = $this->getSetting('format')) {
    }

    if ($opacity = $this->getSetting('opacity')) {
    }

    $settings = $this->getSettings();
    $label = $this->getFieldDefinition()->getLabel();

    if (!empty($settings['opacity'])) {
      $min = 0;
      $constraints[] = $constraint_manager->create('ComplexData', array(
        'opacity' => array(
          'Range' => array(
            'min' => $min,
            'minMessage' => t('%name: the opacity may be no less than %min.', array('%name' => $label, '%min' => $min)),
          )
        ),
      ));

      $max = 1;
      $constraints[] = $constraint_manager->create('ComplexData', array(
        'opacity' => array(
          'Range' => array(
            'max' => $max,
            'maxMessage' => t('%name: the opacity may be no greater than %max.', array('%name' => $label, '%max' => $max)),
          )
        ),
      ));
    }

    // @todo: Adapt constraint based on storage.
    //$constraints[] = $constraint_manager->create('ComplexData', array(
    //  'color' => array(
    //    'Regex' => array(
    //      'pattern' => '/^#(\d+)$/i',
    //    )
    //  ),
    //));

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    //$random = new Random();
    //$values['color'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    //$values['opacity'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    //return $values;
    return '';
  }

}

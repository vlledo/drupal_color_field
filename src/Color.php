<?php

/**
 * @file
 * Contains Drupal\color_field\Color.
 */

namespace Drupal\color_field;

class Color {
  /**
   * The color.
   *
   * @var string
   */
  protected $color;

  /**
   * The opacity.
   *
   * @var float
   */
  protected $opacity;

  /**
   * Creates a Color instance.
   *
   * @param string $color The color.
   * @param float $opacity The opacity.
   */
  public function __construct($color, $opacity) {
    $this->color = $color;
    $this->opacity = $opacity;
  }

  /**
   * {@inheritdoc}
   */
  public function getColor() {
    return $this->color;
  }

  /**
   * {@inheritdoc}
   */
  public function getOpacity() {
    return $this->opacity;
  }

  /**
   * Returns the string representation of the color (color, opacity).
   *
   * @return string
   */
  public function __toString() {
    return $this->color . ' ' . $this->opacity;
  }

}

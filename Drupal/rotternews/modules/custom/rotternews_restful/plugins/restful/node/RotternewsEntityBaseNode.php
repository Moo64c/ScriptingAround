<?php

/**
 * @file
 * Contains \RotternewsEntityBaseNode.
 */

abstract class RotternewsEntityBaseNode extends \RestfulEntityBaseNode {

  /**
   * Overrides \RestfulDataProviderEFQ::controllersInfo().
   */
  public static function controllersInfo() {
    return array(
      '' => array(
        // GET returns a list of entities.
        \RestfulInterface::GET => 'getList',
      ),
      '^.*$' => array(
        \RestfulInterface::GET => 'viewEntities',
      ),
    );
  }

  /**
   * Overrides \RestfulEntityBaseNode::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    unset($public_fields['self']);

    // Set range.
    $this->setRange(10);

    return $public_fields;
  }

  /**
   * Process callback, Remove Drupal specific events from the image array.
   *
   * @param array $value
   *   The image array.
   *
   * @return array
   *   A cleaned image array.
   */
  protected function imageProcess($value) {
    if (static::isArrayNumeric($value)) {
      $output = array();
      foreach ($value as $item) {
        $output[] = $this->imageProcess($item);
      }
      return $output;
    }
    return array(
      'id' => $value['fid'],
      'self' => file_create_url($value['uri']),
      'filemime' => $value['filemime'],
      'filesize' => $value['filesize'],
      'width' => $value['width'],
      'height' => $value['height'],
      'styles' => $value['image_styles'],
    );
  }
}

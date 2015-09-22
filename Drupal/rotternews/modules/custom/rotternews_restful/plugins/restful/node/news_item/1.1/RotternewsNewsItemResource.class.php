<?php

/**
 * @file
 * Contains ProductivityProjectResource.
 */

class RotternewsNewsItemResource extends \RotternewsEntityBaseNode {

  /**
   * Overrides \RestfulEntityBaseNode::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    $public_fields = parent::publicFieldsInfo();

    $public_fields['id'] = array(
      'property' => 'nid',
    );

    $public_fields['body'] = array(
      'property' => 'body',
      'sub_property' => 'value',
    );

    $public_fields['om'] = array(
      'property' => 'field_rotter_id',
    );

    $public_fields['created'] = array(
      'property' => 'created',
    );

    $public_fields['link'] = array(
      'callback' => array($this, 'getNodeUrl'),
    );

    return $public_fields;
  }

  /**
   * Overrides RestfulEntityBase::getEntityFieldQuery.
   */
  public function getEntityFieldQuery() {
    $query = parent::getEntityFieldQuery();
    $query->propertyOrderBy('created', 'DESC');

    return $query;
  }

  /**
   * Get a URL to the node.
   */
  protected function getNodeUrl($wrapper) {
    return url('node/' . $wrapper->getIdentifier(), array('absolute' => TRUE));
  }
}

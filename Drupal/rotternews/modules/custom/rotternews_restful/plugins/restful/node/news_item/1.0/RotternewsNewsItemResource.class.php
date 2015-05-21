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

    return $public_fields;
  }

  /**
   * Overrides RestfulEntityBase::getEntityFieldQuery.
   *
   * When there's a year and a month defined in the request, Filter projects which their end date is bigger,
   * Which will return all projects that are still active in this time.
   */
  public function getEntityFieldQuery() {
    $query = parent::getEntityFieldQuery();
    $request = $this->getRequest();

    $query->propertyOrderBy('created', 'DESC');

    return $query;
  }
}

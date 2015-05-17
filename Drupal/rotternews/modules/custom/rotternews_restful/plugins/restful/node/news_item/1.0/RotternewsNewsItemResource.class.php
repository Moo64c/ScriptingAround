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

    if (!empty($request['year']) && !empty($request['month'])) {
      $start_timestamp =  $request['year'] . '-' . $request['month'] . '-01'. ' 00:00:00';
      $end_timestamp = date('Y-m-d 00:00:00', strtotime('+1 month', strtotime($start_timestamp)));
      $query
        ->fieldCondition('field_date', 'value', $end_timestamp, '<=')
        ->fieldCondition('field_date', 'value2', $start_timestamp, '>=')
        ->addTag('empty_end_date');
    }

    return $query;
  }
}

<?php

/**
 * @file
 * Contains \RestfulSearchAPIBasicSearch.
 */

class RestfulSearchAPIBasicSearch extends \RestfulDataProviderSearchAPI implements \RestfulInterface {

  /**
   * Overrides \RestfulBase::publicFieldsInfo().
   */
  public function publicFieldsInfo() {
    return array(
      'entity_id' => array(
        'property' => 'search_api_id',
        'process_callbacks' => array(
          'intVal',
        ),
      ),
      'version_id' => array(
        'property' => 'vid',
        'process_callbacks' => array(
          'intVal',
        ),
      ),
      'relevance' => array(
        'property' => 'search_api_relevance',
      ),
      'body' => array(
        'property' => 'body',
        'sub-property' => LANGUAGE_NONE . '::0::value',
      ),
      'label' => array(
        'property' => 'title',
      ),
      'om' => array(
        'property' => 'field_rotter_id',
        'sub-property' => LANGUAGE_NONE . '::0::value',
      ),
      'created' => array(
        'property' => 'created',
      ),
    );
  }

  /**
   * Override default sort.
   */
  public function defaultSortInfo() {
    return array(
      'created',
      'relevance',
      'om',
    );
  }

}

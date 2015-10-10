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
   * {@inheritdoc}
   *
   * @throws \RestfulServerConfigurationException
   *   If the provided search index does not exist.
   */
  public function view($id) {
    // In this case the ID is the search query.
    $options = $output = array();
    $request = $this->getRequest();
    // Construct the options array.

    // limit: The maximum number of search results to return. -1 means no limit.
    $options['limit'] = $this->getRange();

    // offset: The position of the first returned search results relative to the
    // whole result in the index.
    $page = empty($request['page']) ? 0 : $request['page'];
    $options['offset'] = $options['limit'] * $page;

    watchdog(WATCHDOG_DEBUG, 'request:' . implode(',', $request));
    try {
      // Query SearchAPI for the results
      $search_results = $this->executeQuery($id, $options);
//      watchdog(WATCHDOG_DEBUG, 'search_results:' . implode(',', $search_results));
      foreach ($search_results as $search_result) {
        $output[] = $this->mapSearchResultToPublicFields($search_result);
      }
      watchdog(WATCHDOG_DEBUG, 'output:' . implode(',', $output));
    }
    catch (\SearchApiException $e) {
      // Relay the exception with one of RESTful's types.
      throw new \RestfulServerConfigurationException(format_string('Search API Exception: @message', array(
        '@message' => $e->getMessage(),
      )));
    }

    // This is an emergency sort. Only apply it if no sort could be applied.
    $any_sort_applied = array_filter(array_values($this->sorted));
    $result = reset($output);
    $available_keys = array_keys($result);
    if (!$any_sort_applied) {
      $this->manualArraySort($available_keys, $output);
    }

    return $output;
  }
}

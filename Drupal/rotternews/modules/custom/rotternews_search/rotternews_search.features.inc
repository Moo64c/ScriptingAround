<?php
/**
 * @file
 * rotternews_search.features.inc
 */

/**
 * Implements hook_default_search_api_index().
 */
function rotternews_search_default_search_api_index() {
  $items = array();
  $items['news_index'] = entity_import('search_api_index', '{
    "name" : "News index",
    "machine_name" : "news_index",
    "description" : null,
    "server" : "solr_searcher",
    "item_type" : "node",
    "options" : {
      "index_directly" : 1,
      "cron_limit" : "50",
      "fields" : {
        "body:value" : { "type" : "text" },
        "changed" : { "type" : "date" },
        "created" : { "type" : "date" },
        "field_comments" : { "type" : "text" },
        "field_reporter" : { "type" : "integer", "entity_type" : "node" },
        "field_rotter_id" : { "type" : "text" },
        "field_views" : { "type" : "text" },
        "nid" : { "type" : "integer" },
        "search_api_language" : { "type" : "string" },
        "title" : { "type" : "text" },
        "url" : { "type" : "uri" }
      },
      "data_alter_callbacks" : {
        "search_api_alter_bundle_filter" : {
          "status" : 0,
          "weight" : "-10",
          "settings" : { "default" : "1", "bundles" : [] }
        },
        "search_api_alter_node_access" : { "status" : 0, "weight" : "0", "settings" : [] },
        "search_api_alter_node_status" : { "status" : 1, "weight" : "0", "settings" : [] },
        "search_api_alter_add_hierarchy" : { "status" : 0, "weight" : "0", "settings" : { "fields" : [] } },
        "search_api_alter_add_viewed_entity" : { "status" : 0, "weight" : "0", "settings" : { "mode" : "full" } },
        "search_api_alter_add_url" : { "status" : 0, "weight" : "0", "settings" : [] },
        "search_api_alter_add_aggregation" : { "status" : 0, "weight" : "0", "settings" : [] }
      },
      "processors" : {
        "search_api_case_ignore" : {
          "status" : 1,
          "weight" : "0",
          "settings" : { "fields" : {
              "title" : true,
              "field_rotter_id" : true,
              "field_comments" : true,
              "field_views" : true,
              "body:value" : true
            }
          }
        },
        "search_api_html_filter" : {
          "status" : 1,
          "weight" : "10",
          "settings" : {
            "fields" : {
              "title" : true,
              "field_rotter_id" : true,
              "field_comments" : true,
              "field_views" : true,
              "body:value" : true
            },
            "title" : 0,
            "alt" : 1,
            "tags" : "h1 = 5\\r\\nh2 = 3\\r\\nh3 = 2\\r\\nstrong = 2\\r\\nb = 2\\r\\nem = 1.5\\r\\nu = 1.5"
          }
        },
        "search_api_tokenizer" : {
          "status" : 0,
          "weight" : "20",
          "settings" : {
            "fields" : {
              "title" : true,
              "field_rotter_id" : true,
              "field_comments" : true,
              "field_views" : true,
              "body:value" : true
            },
            "spaces" : "[^[:alnum:]]",
            "ignorable" : "[\\u0027]"
          }
        },
        "search_api_stopwords" : {
          "status" : 0,
          "weight" : "30",
          "settings" : {
            "fields" : {
              "title" : true,
              "field_rotter_id" : true,
              "field_comments" : true,
              "field_views" : true,
              "body:value" : true
            },
            "file" : "",
            "stopwords" : "but\\r\\ndid\\r\\nthe this that those\\r\\netc"
          }
        },
        "search_api_highlighting" : {
          "status" : 0,
          "weight" : "35",
          "settings" : {
            "prefix" : "\\u003Cstrong\\u003E",
            "suffix" : "\\u003C\\/strong\\u003E",
            "excerpt" : 1,
            "excerpt_length" : "256",
            "exclude_fields" : [],
            "highlight" : "always"
          }
        }
      }
    },
    "enabled" : "1",
    "read_only" : "0",
    "rdf_mapping" : []
  }');
  return $items;
}

/**
 * Implements hook_default_search_api_page().
 */
function rotternews_search_default_search_api_page() {
  $items = array();
  $items['search_news'] = entity_import('search_api_page', '{
    "index_id" : "news_index",
    "path" : "search-news",
    "name" : "Search news",
    "machine_name" : "search_news",
    "description" : null,
    "options" : {
      "mode" : "terms",
      "fields" : { "body:value" : "body:value", "title" : "title" },
      "per_page" : "10",
      "get_per_page" : 0,
      "result_page_search_form" : 1,
      "view_mode" : "search_api_page_result"
    },
    "enabled" : "1",
    "rdf_mapping" : []
  }');
  return $items;
}

/**
 * Implements hook_default_search_api_server().
 */
function rotternews_search_default_search_api_server() {
  $items = array();
  $items['solr_searcher'] = entity_import('search_api_server', '{
    "name" : "Solr searcher",
    "machine_name" : "solr_searcher",
    "description" : "",
    "class" : "search_api_solr_service",
    "options" : {
      "clean_ids" : true,
      "site_hash" : true,
      "scheme" : "http",
      "host" : "solr-rotternews.rhcloud.com",
      "port" : "80",
      "path" : "collection1",
      "http_user" : "Moo64cAdmin",
      "http_pass" : "tyughj12",
      "excerpt" : 0,
      "retrieve_data" : 0,
      "highlight_data" : 0,
      "skip_schema_check" : 0,
      "solr_version" : "",
      "http_method" : "AUTO"
    },
    "enabled" : "1",
    "rdf_mapping" : []
  }');
  return $items;
}

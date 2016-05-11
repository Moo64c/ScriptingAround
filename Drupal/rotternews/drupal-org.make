core = 7.x
api = 2

; Modules
projects[admin_menu][subdir] = "contrib"
projects[admin_menu][version] = "3.0-rc4"

projects[admin_views][subdir] = "contrib"
projects[admin_views][version] = "1.3"

projects[ctools][subdir] = "contrib"
projects[ctools][version] = "1.4"

projects[date][subdir] = "contrib"
projects[date][version] = "2.8"

projects[devel][subdir] = "contrib"
projects[devel][version] = "1.5"

projects[entity][subdir] = "contrib"
projects[entity][version] = "1.7"

projects[entityreference][subdir] = "contrib"
projects[entityreference][version] = "1.1"

projects[entityreference_prepopulate][subdir] = "contrib"
projects[entityreference_prepopulate][version] = "1.5"
projects[entityreference_prepopulate][patch][] = "https://drupal.org/files/issues/1994702-values-from-cache-20.patch"

projects[features][subdir] = "contrib"
projects[features][version] = "2.2"

projects[feeds][subdir] = "contrib"
projects[feeds][version] = "2.x-dev"

projects[field_collection][subdir] = "contrib"
projects[field_collection][version] = "1.0-beta5"

projects[flag][subdir] = "contrib"
projects[flag][version] = "2.2"

projects[facetapi][subdir] = "contrib"
projects[facetapi][version] = "1.5"

projects[inline_entity_form][subdir] = "contrib"
projects[inline_entity_form][version] = "1.5"

projects[jquery_update][subdir] = "contrib"
projects[jquery_update][version] = "2.4"

projects[libraries][subdir] = "contrib"
projects[libraries][version] = "2.2"

projects[module_filter][subdir] = "contrib"
projects[module_filter][version] = "2.0-alpha2"

projects[panels][subdir] = "contrib"
projects[panels][version] = "3.4"

projects[pathauto][subdir] = "contrib"
projects[pathauto][version] = "1.2"

projects[pathologic][subdir] = "contrib"
projects[pathologic][version] = "2.12"

projects[plug][subdir] = "contrib"
projects[plug][version] = "1.1"

projects[purl][subdir] = "contrib"
projects[purl][version] = "1.x-dev"

projects[registry_autoload][subdir] = "contrib"
projects[registry_autoload][version] = "1.3"

projects[restful][download][type] = "git"
projects[restful][download][url] = "https://github.com/RESTful-Drupal/restful.git"
projects[restful][download][branch] = "7.x-1.x"
projects[restful][subdir] = "contrib"
projects[restful][patch][] = "https://patch-diff.githubusercontent.com/raw/RESTful-Drupal/restful/pull/889.patch"

projects[restful_search_api][download][type] = "git"
projects[restful_search_api][download][url] = "git://github.com/RESTful-Drupal/restful_search_api.git"
projects[restful_search_api][download][branch] = "7.x-1.x"
projects[restful_search_api][subdir] = "contrib"

projects[search_api][subdir] = "contrib"
projects[search_api][version] = "1.13"

projects[search_api_solr][subdir] = "contrib"
projects[search_api_solr][version] = "1.7"

projects[search_api_db][subdir] = "contrib"
projects[search_api_db][version] = "1.4"

projects[strongarm][subdir] = "contrib"
projects[strongarm][version] = "2.0"

projects[title][subdir] = "contrib"
projects[title][version] = "1.0-alpha7"

projects[token][subdir] = "contrib"
projects[token][version] = "1.5"

projects[views][subdir] = "contrib"
projects[views][version] = "3.8"

projects[views_bulk_operations][subdir] = "contrib"
projects[views_bulk_operations][version] = "3.2"

; Themes

projects[bootstrap][subdir] = "contrib"
projects[bootstrap][version] = "3.0"

; Libraries

libraries[bootstrap_sass][download][type] = "file"
libraries[bootstrap_sass][type] = "libraries"
libraries[bootstrap_sass][download][url] = "https://github.com/twbs/bootstrap-sass/archive/v3.1.1.zip"

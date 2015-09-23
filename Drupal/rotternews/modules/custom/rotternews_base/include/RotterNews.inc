<?php
require_once("RotterInfo.inc");
require_once("RotterSort.inc");
require_once("RotterCloud.inc");

$version = RotterInfo::$version;
define("ROTTER_REQUEST_BASE_URL", RotterInfo::$base_url);
date_default_timezone_set("Asia/Jerusalem");

/**
 * @param $node
 * @return mixed
 * Retrieve full HTML from inside a node.
 */
function rotternews_innerXML($node) {
  $doc  = $node->ownerDocument;
  $frag = $doc->createDocumentFragment();
  foreach ($node->childNodes as $child)     {
    $frag->appendChild($child->cloneNode(TRUE));
  }

  $text = $doc->saveXML($frag);

  // Clean a bunch of stuff we don't want.
  $text = strip_tags($text, RotterInfo::$allowed_tags);

  $text = str_replace(array_keys(RotterInfo::$replace_strings), RotterInfo::$replace_strings, $text);

  return $text;
}

/**
 * Request an update from Rotter's scoops forum.
 * @param $sorting_method string
 *   Sorting method to use.
 * @param $request_url string
 *  Future support for other Rotter forums.
 * @return array
 *  Content received parsed to an array,
 */
function rotternews_get_update_data($sorting_method = "", $request_url = ROTTER_REQUEST_BASE_URL) {
  if ($sorting_method == "") {
    $sorting_method = RotterInfo::$default_sort;
  }

  if (!$doc = rotternews_get_DOM_from_url($request_url)) {
    return _rotternews_get_error_message(0);
  }
  $load_time = time();

  $links = $doc->getElementsByTagName('a');

  $content = array();
  $id = 1;
  for ($i = 0; $i < $links->length; $i++) {
    $link = $links->item($i);
    $url =  $link->attributes->getNamedItem("href")->textContent;
    $local_print = "";
    $title = "";
    $href = "";

    if (strpos($url, 'forum=scoops1') && strpos($url, 'az=read_count') && !strpos($url, "mm=") ) {

      // Change link.
      $frag = "";
      foreach ($link->attributes as $attribute) {
        if ($attribute->name == 'href') {
          $href = urlencode($attribute->value);
          $om = _rotternews_get_post_om($url);

          // Change the link clicked to javascript.
          $attribute->value ='javascript:getFirstPost("' . $href . '",'. $om . ')';

          $frag = $doc->createDocumentFragment();
          // Add external link to the original post.

          $external_link_image = $doc->createElement('img');
          $external_link_image->setAttribute('src', 'style/images/external.png');
          $external_link_image->setAttribute('class', 'external-image');

          $external_link = $doc->createElement("a");
          $external_link->appendChild($external_link_image);
          $external_link->setAttribute("href", urldecode($href));
          $external_link->setAttribute("target", "_blank");
          $frag->appendChild($external_link->cloneNode(TRUE));

          $original_link = $doc->createElement("a");
          $title = $link->textContent;
          $original_link->appendChild($doc->createTextNode($title));
          $original_link->setAttribute('href', 'javascript:getFirstPost("' . $href . '",'. $om . ')');
          $frag->appendChild($original_link->cloneNode(TRUE));
        }
      }
      $link_parent = $link->parentNode->parentNode->parentNode;

      // Get the date and time.
      $time = $link_parent->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
      $date = trim($time->firstChild->textContent, chr(0xC2).chr(0xA0));
      $date = explode(".", $date);
      // Should be good until the year 2100.
      $date[2] = 2000 + $date[2];
      $date = implode(".", $date);
      $time = $time->firstChild->nextSibling->textContent;

      $timestamp = strtotime("$date $time");

      $comments =  $link_parent->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->textContent;
      $views = $link_parent->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->textContent;

      // Add the rows to be printed.
      $local_print .= '<abbr class="timeago" title="' . gmdate('Y-m-d\TH:i:s\Z', $timestamp) . '"></abbr>';
      $local_print .= '<div class="news-item" id="news-item-' . $om . '">';
      $local_print .= rotternews_innerXML($frag);
      $local_print .= '<div class="content-holder" id="content-holder-'. $om . '"></div>';
      $local_print .= '</div>';

      // Add the data with sorting abilities.
      $content[$id] = array(
        'om' => $om,
        'title' => $title,
        'to_print' => $local_print,
        'views' => $views,
        'comments' => $comments,
        'native_id' => $id,
        'timestamp' => $timestamp,
        'time_passed' => $load_time - $timestamp,
        'href' => $url,
      );

      $id++;
    }
  }

  // Sort by whatever.
  if ($sorting_method != 'native') {
    usort($content, "content_sort_$sorting_method");
  }

  return $content;
}

/**
 * Request an update from Rotter's scoops forum.
 * @param $sorting_method string
 *   Sorting method to use.
 * @param $request_url string
 *  Future support for other Rotter forums.
 * @return string
 *  Parsed data as a JSON encoded string.
 */
function rotternews_get_update_JSON($sorting_method = "", $request_url = ROTTER_REQUEST_BASE_URL) {
  return json_encode(rotternews_get_update_data($sorting_method, $request_url));
}

/**
 * Request an update from Rotter's scoops forum.
 * @param $sorting_method string
 *   Sorting method to use.
 * @param $request_url string
 *  Future support for other Rotter forums.
 * @return string
 *  HTML including the actual news.
 */
function rotternews_get_update($sorting_method = "", $request_url = ROTTER_REQUEST_BASE_URL) {
  // Return the sorted array.
  $content = rotternews_get_update_data($sorting_method, $request_url);

  $print_to_add = "";
  $cloud_text = "";
  foreach ($content as $id => $row) {
    $class = $id % 2 == 0 ? "even" : "odd";
    $print_to_add .= '<div class="news-item-wrapper '. $class . '">';
    $print_to_add .= $row['to_print'];
    $print_to_add .= '</div>';
    $cloud_text .= $row['title'] . " ";
  }

  $cloud = rotternews_get_tag_cloud($cloud_text);
  return $cloud . $print_to_add;
}

/**
 * Helper function to get the HTML DOM from a request url.
 * @param $request_url
 * @return DOMDocument
 */
function rotternews_get_DOM_from_url($request_url) {
  libxml_use_internal_errors(true);
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_URL, $request_url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  // Set 2 seconds timeout.
  curl_setopt($curl, CURLOPT_TIMEOUT, 2);
  $str = curl_exec($curl);
  curl_close($curl);

  if (!$str)  {
    return FALSE;
  }

  // Create a DOM object.
  $html_base = new DOMDocument();
  // Load HTML from a string.
  $html_base->loadHTML($str);
  libxml_clear_errors();
  return $html_base;
}

/**
 * Prints the first post from a rotter thread.
 * @param $url
 *  Thread URL
 * @param $id
 *  Local ID granted by the main page.
 * @return string
 *  Thread's first post as a string.
 */
function rotternews_get_first_post($url, $id) {
  $om = _rotternews_get_post_om($url);
  $new_url = "http://rotter.net/forum/scoops1/$om.shtml";

  if (!$doc = rotternews_get_DOM_from_url($new_url)) {
    return _rotternews_get_error_message(0);
  }
  // Find the main "div" and work from there.
  $tables_rows = $doc->getElementsByTagName('tr');
  for($i = 0; $i < $tables_rows->length; $i++) {
    $table_row = $tables_rows->item($i);
    if (!empty($table_row->attributes->getNamedItem("bgcolor")->nodeValue) &&
      $table_row->attributes->getNamedItem("bgcolor")->nodeValue == "#FDFDFD" ) {

      // Remove attributes for "font" and "td" elements.
      _rotternews_remove_attributes($doc, array("font", "td", "table"));

      // Remove scripts.
      foreach($doc->getElementsByTagName('script') as $script) {
        $script->parentNode->parentNode->removeChild($script->parentNode);
      }

      // Add a "target=_blank" to each link.
      foreach($doc->getElementsByTagName('a') as $link) {
        $link->setAttribute("target", "_blank");
        $parse = parse_url($link->nodeValue);

        // Change links' text to just their domain. (Prevents box size messes).
        if (!empty($parse['host'])) {
          $link->nodeValue = $parse['host'];
        }
        else {
          $link->nodeValue = "";
        }
      }

      // Add a link to new tab for each image.
      foreach($doc->getElementsByTagName('img') as $image) {
        $image_url = $image->attributes->getNamedItem("src")->nodeValue;
        $parent =$image->parentNode;

        foreach(RotterInfo::$image_removal_hints as $needle) {
          $image_url_lower = strtolower($image_url);
          if (strpos($image_url_lower, strtolower($needle)) !== FALSE) {
            $image_url ="";
            break;
          }
        }

        // Rebuild the image with the link.
        $new_image = $doc->createElement('img');
        $new_image->setAttribute("src", $image_url);

        $new_href = $doc->createElement('a');
        $new_href->setAttribute("href", $image_url);
        $new_href->setAttribute("target", "_blank");
        $clone = $new_image->cloneNode();
        $new_href->appendChild( $clone );

        $parent->replaceChild( $new_href, $image );
      };

      return rotternews_innerXML($table_row);
    }
  }
}

/**
 * Removes all attributes from specific kind(s) of element(s).
 * @param DOMDocument $doc
 *  Document to use.
 * @param $names array
 *   Array of strings to search for.
 */
function _rotternews_remove_attributes(DOMDocument &$doc, $names) {
  foreach ($names as $name) {
    foreach($doc->getElementsByTagName($name) as $element) {
      $attributes = $element->attributes;
      while ($attributes->length) {
        $element->removeAttribute($attributes->item(0)->name);
      }
    }
  }
}

/**
 * Gets an error message.
 * @param $code integer
 *  Error code.
 * @return String
 *  Error message.
 */
function _rotternews_get_error_message($code) {
  return RotterInfo::_get_error_message($code);
}

/**
 * Gets the Rotter OM of the post.
 * @param $url
 *  Post URL.
 * @return string
 *  The post's ID.
 */
function _rotternews_get_post_om($url) {
  $url_parts = explode("&", $url);
  if (!empty($url_parts[1])) {
    return  str_replace("om=", "", $url_parts[1]);
  }
  return FALSE;
}

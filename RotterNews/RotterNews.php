<?php
require_once("RotterInfo.php");
require_once("RotterSort.php");

$version = RotterInfo::$version;
define("BASE_URL", RotterInfo::$base_url);
date_default_timezone_set("Asia/Jerusalem");

/**
 * @param $node
 * @return mixed
 * Retrieve full HTML from inside a node.
 */
function innerXML($node) {
  $doc  = $node->ownerDocument;
  $frag = $doc->createDocumentFragment();
  foreach ($node->childNodes as $child)     {
    $frag->appendChild($child->cloneNode(TRUE));
  }

  $text = $doc->saveXML($frag);
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
function get_update_data($sorting_method, $request_url) {
  if ($sorting_method == "") {
    $sorting_method = RotterInfo::$default_sort;
  }

  if (!$doc = get_DOM_from_url($request_url)) {
    return _get_error_message(0);
  }
  $load_time = time();

  $links = $doc->getElementsByTagName('a');

  $content = array();
  $id = 1;
  for ($i = 0; $i < $links->length; $i++) {
    $link = $links->item($i);
    $url =  $link->attributes->getNamedItem("href")->textContent;
    $local_print = "";

    if (strpos($url, 'forum=scoops1') && strpos($url, 'az=read_count') && !strpos($url, "mm=") ) {

      // Change link.
      $frag = "";
      foreach ($link->attributes as $attribute) {
        if ($attribute->name == 'href') {
          $href = urlencode($attribute->value);
          $om = _get_post_om($url);

          // Change the link clicked to javascript.
          $attribute->value ='javascript:getFirstPost("' . $href . '",'. $om . ')';

          // Add external link to the original post.
          $external_link = $doc->createElement("a");

          $external_link_image = $doc->createElement('img');
          $external_link_image->setAttribute('src', 'style/images/external.png');
          $external_link_image->setAttribute('class', 'external-image');
          $external_link->appendChild($external_link_image);
          $external_link->setAttribute("href", urldecode($href));
          $external_link->setAttribute("target", "_blank");
          $frag = $doc->createDocumentFragment();
          $frag->appendChild($external_link->cloneNode(TRUE));
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

      $comments = $link_parent->nextSibling->nextSibling->nextSibling->nextSibling->textContent;
      $views = $link_parent->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->firstChild->nextSibling->firstChild->textContent;
      $views = intval($views) == 0 ? 1 : intval($views);

      // Add the rows to be printed.
      $local_print .= innerXML($frag);
      $local_print .= '<abbr class="timeago" title="' . gmdate('Y-m-d\TH:i:s\Z', $timestamp) . '"></abbr>';
      $local_print .= '<div class="news-item" id="news-item-' . $om . '">';
      $local_print .= innerXML($link_parent->lastChild->lastChild);
      $local_print .= '<div class="content-holder" id="content-holder-'. $om . '"></div>';
      $local_print .= '</div>';

      // Add the data with sorting abilities.
      $content[$id] = array(
        'om' => $om,
        'to_print' => $local_print,
        'views' => $views,
        'comments' => $comments,
        'native_id' => $id,
        'timestamp' => $timestamp,
        'time_passed' => $load_time - $timestamp,
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
function get_update_JSON($sorting_method = "", $request_url = BASE_URL) {
  return json_encode(get_update_data($sorting_method, $request_url));
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
function get_update($sorting_method = "", $request_url = BASE_URL) {
  $content = get_update_data($sorting_method, $request_url);
  $print = "";
  // Return the sorted array.
  foreach ($content as $id => $row) {
    $class = $id % 2 == 0 ? "even" : "odd";
    $print .= '<div class="news-item-wrapper '. $class . '">';
    $print .= $row['to_print'];
    $print .= '</div>';
  }

  return $print;
}

/**
 * Helper function to get the HTML DOM from a request url.
 * @param $request_url
 * @return DOMDocument
 */
function get_DOM_from_url($request_url) {
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
function get_first_post($url, $id) {
  $om = _get_post_om($url);
  $new_url = "http://rotter.net/forum/scoops1/$om.shtml";

  if (!$doc = get_DOM_from_url($new_url)) {
    return _get_error_message(0);
  }
  // Find the main "div" and work from there.
  $tables_rows = $doc->getElementsByTagName('tr');
  for($i = 0; $i < $tables_rows->length; $i++) {
    $table_row = $tables_rows->item($i);
    if ($table_row->attributes->getNamedItem("bgcolor")->nodeValue == "#FDFDFD" ) {

      // Remove attributes for "font" and "td" elements.
      _remove_attributes($doc, array("font", "td", "table"));

      // Remove scripts.
      foreach($doc->getElementsByTagName('script') as $script) {
        $script->parentNode->parentNode->removeChild($script->parentNode);
      }

      // Add a "target=_blank" to each link.
      foreach($doc->getElementsByTagName('a') as $link) {
        $link->setAttribute("target", "_blank");
        $parse = parse_url($link->nodeValue);

        // Change links' text to just their domain. (Prevents box size messes).
        $link->nodeValue = $parse['host'];
      }

      // Add link for shadowbox before each image.
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

        // Create a new image without any attributes, with shadowbox link.
        $new_image = $doc->createElement('img');
        $new_image->setAttribute("src", $image_url);

        $shadow_href = $doc->createElement('a');
        $shadow_href->setAttribute("rel", "shadowbox[post-$id]");
        $shadow_href->setAttribute("href", $image_url);
        $shadow_href->setAttribute("class", "shadowbox-link");
        $clone = $new_image->cloneNode();
        $shadow_href->appendChild( $clone );

        $parent->replaceChild( $shadow_href, $image );
      };

      return innerXML($table_row);
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
function _remove_attributes(DOMDocument &$doc, $names) {
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
function _get_error_message($code) {
  return RotterInfo::get_error_message($code);
}

/**
 * Gets the Rotter OM of the post.
 * @param $url
 *  Post URL.
 * @return string
 *  The post's ID.
 */
function _get_post_om($url) {
  $url_parts = explode("&", $url);
  if (!empty($url_parts[1])) {
    return  str_replace("om=", "", $url_parts[1]);
  }
  return FALSE;
}

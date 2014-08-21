<?php

// Final html to be printed in the index.php file.
$raw_html = "";
define("BASE_URL", "http://rotter.net/scoopscache.html");
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

  // Handle signatures.
  $text = str_replace('src="http://rotter.net/User_files/forum/signatures/', "src=\"style/images/signature.png?q=", $text);
  $text = str_replace('src="/User_files/forum/signatures/', "src=\"style/images/signature.png?q=", $text);
  $text = str_replace('href="/User_files/forum/signatures/', "href=\"http://rotter.net/User_files/forum/signatures/", $text);

  return $text;
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
function get_update($sorting_method = 'native', $request_url = BASE_URL) {
  $doc = get_DOM_from_url($request_url);
  $load_time = time();

  $links = $doc->getElementsByTagName('a');

  $content = array();
  $id = 1;
  for ($i = 0; $i < $links->length; $i++) {
    $link = $links->item($i);
    $url =  $link->attributes->getNamedItem("href")->textContent;
    $local_print = "";

    if (strpos($url, 'forum=scoops1') && strpos($url, 'az=read_count') && !strpos($url, "mm=") ) {
      $local_print .= '<div class="news-item" id="news-item-"' . $id . '>';

      $row = $link->parentNode->parentNode->parentNode->parentNode;
      // Change link.
      foreach ($link->attributes as $attribute) {
        if ($attribute->name == 'href') {
          $href = urlencode($attribute->value);

          // Change the link clicked to javascript.
          $attribute->value ='javascript:getFirstPost("' . $href . '",'. $id . ')';

          // Add external link to the original post.
          $external_link = $doc->createElement("a");

          $external_link_image = $doc->createElement('img');
          $external_link_image->setAttribute('src', 'style/images/external.png');
          $external_link_image->setAttribute('class', 'external-image');
          $external_link->appendChild($external_link_image);
          $external_link->setAttribute("href", 'javascript:openInNewWindow("' . $href . '")');
          $external_link->setAttribute("target", "_blank");

          $row->insertBefore($external_link, $link->parentNode->parentNode->parentNode->previousSibling);

        }
      }
      $link_parent = $link->parentNode->parentNode->parentNode;

      // Get the date and time.
      $time = $link_parent->nextSibling->nextSibling->firstChild->nextSibling->firstChild;
      $time->removeChild($time->firstChild->nextSibling->nextSibling->nextSibling);
      $date = trim($time->firstChild->textContent, chr(0xC2).chr(0xA0));
      $date = explode(".", $date);
      // Should be good until the year 2100.
      $date[2] = 2000 + $date[2];
      $date = implode(".", $date);
      $time = $time->firstChild->nextSibling->textContent;

      $timestamp = strtotime("$date $time");

      // Remove unnecessary information.
      $row->removeChild($link_parent->nextSibling->nextSibling);
      $row->removeChild($link_parent->nextSibling->nextSibling->nextSibling);
      $row->removeChild($link_parent->previousSibling);

      $comments = $link_parent->nextSibling->nextSibling->nextSibling->nextSibling->textContent;
      $views = $link_parent->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling->firstChild->nextSibling->firstChild->textContent;
      $views = intval($views) == 0 ? 1 : intval($views);

      $row->removeChild($link_parent->nextSibling->nextSibling->nextSibling->nextSibling);
      $row->removeChild($link_parent->nextSibling->nextSibling->nextSibling->nextSibling->nextSibling);


      $local_print .= innerXML($row);
      $local_print .= '<abbr class="timeago" title="' . gmdate('Y-m-d\TH:i:s\Z', $timestamp) . '"></abbr>';
      $local_print .= '<div class="content-holder" id="content-holder-'. $id . '"></div>';
      $local_print .= '</div>';

      // Add the data with sorting abilities.
      $content[$id] = array(
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

  $print = "";

  // Sort by whatever.
  if ($sorting_method != 'native') {
    usort($content, "content_sort_$sorting_method");
  }

  // Return the sorted array.
  foreach ($content as $row) {
    $print .= $row['to_print'];
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
  $str = curl_exec($curl);
  curl_close($curl);

  // Create a DOM object
  $html_base = new DOMDocument();
  // Load HTML from a string
  $html_base->loadHTML($str);
  return $html_base;
}

/**
 * Prints the first post from a rotter thread.
 * @param $url
 *  Thread URL
 * @param $id
 *  Local ID granted by the main page.
 */
function get_first_post($url, $id) {
  $url_parts = explode("&", $url);
  print_r($url_parts);
  $om = str_replace("om=", "", $url_parts[1]);
  $new_url = "http://rotter.net/forum/scoops1/$om.shtml";
  $doc = get_DOM_from_url($new_url);
  // Find the main "div" and work from there.
  $tables_rows = $doc->getElementsByTagName('tr');
  for($i = 0; $i < $tables_rows->length; $i++) {
    $table_row = $tables_rows->item($i);
    if ($table_row->attributes->getNamedItem("bgcolor")->nodeValue == "#FDFDFD" ) {

      // Remove attributes for "font" and "td" elements.
      _remove_attributes($doc, array("font", "td", "table"));

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
        $shadow_href = $doc->createElement('a');
        $shadow_href->setAttribute("rel", "shadowbox[post-$id]");
        $shadow_href->setAttribute("href", $image_url);
        $shadow_href->setAttribute("class", "shadowbox-link");
        $clone = $image->cloneNode();
        $shadow_href->appendChild( $clone );

        $image->parentNode->replaceChild( $shadow_href, $image );
      };

      print innerXML($table_row);
      break;
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
function _remove_attributes(DOMDocument $doc, $names) {
  foreach ($names as $name) {
    foreach($doc->getElementsByTagName($name) as $element) {
      $attributes = $element->attributes;
      while ($attributes->length) {
        $element->removeAttribute($attributes->item(0)->name);
      }
    }
  }
}

// -------------- SORTING FUNCTIONS -----------
function get_content_sorters() {
  return array(
    'native' => "Native",
    'time' => "Newest",
    'views' => "Views",
    'comments' => "Comments",
    'comments_to_views' => "Comments/views",
    'comments_to_time' => "Comments/time",
    'views_to_time' => "Views/time",
  );
}

function content_sort_views($first_element, $second_element) {
  return $second_element['views'] - $first_element['views'];
}

function content_sort_comments($first_element, $second_element) {
  return $second_element['comments'] - $first_element['comments'];
}

function content_sort_time($first_element, $second_element) {
  return $first_element['time_passed'] - $second_element['time_passed'];
}

function content_sort_comments_to_views($first_element, $second_element) {
  return 1000 * (($second_element['comments'] / $second_element['views']) - ($first_element['comments'] / $first_element['views']));
}

function content_sort_comments_to_time($first_element, $second_element) {
  return 1000 * (($second_element['comments'] / ($second_element['time_passed'])) - ($first_element['comments'] / ($first_element['time_passed'])));
}

function content_sort_views_to_time($first_element, $second_element) {
  return 1000 * (($second_element['views'] / $second_element['time_passed']) - ($first_element['views'] / $first_element['time_passed']));
}

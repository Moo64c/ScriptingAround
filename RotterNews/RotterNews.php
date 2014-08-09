<?php

// Final html to be printed in the index.php file.
$raw_html = "";
define("BASE_URL", "http://rotter.net/scoopscache.html");

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
  $text = str_replace("תמונות", '<i>תמונות</i>', $text);
  return $text;
}

/**
 * Request an update from Rotter's scoops forum.
 * @param $request_url string
 *  Future support for other Rotter forums.
 * @return string
 *  HTML including the actual news.
 */
function get_update($request_url = BASE_URL) {
  $doc = get_DOM_from_url($request_url);

  $links = $doc->getElementsByTagName('a');

  $print = "";
  $id = 1;
  for ($i = 0; $i < $links->length; $i++) {
    $link = $links->item($i);
    $url =  $link->attributes->getNamedItem("href")->textContent;

    if (strpos($url, 'forum=scoops1') && strpos($url, 'az=read_count') && !strpos($url, "mm=") ) {
      $print .= '<div class="news-item">';

      $row = $link->parentNode->parentNode->parentNode->parentNode;
      // Change link.
      foreach ($link->attributes as $attribute) {
        if ($attribute->name == 'href') {
          $original_href = $attribute->value;
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
          $link->appendChild($external_link);
        }
      }

      // Remove unnecessary information.
      $row->removeChild($row->firstChild->nextSibling->nextSibling->nextSibling);
      $row->removeChild($row->firstChild->nextSibling->nextSibling->nextSibling);
      $row->removeChild($row->firstChild->nextSibling->nextSibling->nextSibling);

      $print .=  innerXML($row);
      $print .=  '<div class="content-holder" id="content-holder-'. $id . '"></div></div>';
      $id++;
    }
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

function get_first_post($url, $id) {
  $doc = get_DOM_from_url($url);
  // Find the main "div" and work from there.
  $tables_rows = $doc->getElementsByTagName('tr');
  for($i = 0; $i < $tables_rows->length; $i++) {
    $table_row = $tables_rows->item($i);
    if ($table_row->attributes->getNamedItem("bgcolor")->nodeValue == "#FDFDFD" ) {

      // Add a "target=_blank" to each link.
      foreach($doc->getElementsByTagName('a') as $link) {
        $link->setAttribute("target", "_blank");
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


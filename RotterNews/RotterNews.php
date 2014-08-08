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
  return $doc->saveXML($frag);
}

/**
 * Request an update from Rotter's scoops forum.
 * @param $request_url string
 *  Future support for other Rotter forums.
 * @return string
 *  HTML including the actual news.
 */
function getUpdate($request_url = BASE_URL) {
  $doc = get_DOM_from_url($request_url);

  $links = $doc->getElementsByTagName('a');

  $print = "";
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
          $attribute->value ='javascript:getFirstPost("' . $href . '")';

          // Add external link to the original post.
          $external_link = $doc->createElement("a");

          $external_link_image = $doc->createElement('img');
          $external_link_image->setAttribute('src', 'external.png');
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
      $print .=  '</div>';

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

function get_first_post($url) {
  $html_base = get_DOM_from_url($url);
}


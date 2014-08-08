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
 */
function getUpdate() {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_URL, BASE_URL);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  $str = curl_exec($curl);
  curl_close($curl);


  // Create a DOM object
  $html_base = new DOMDocument();
  // Load HTML from a string
  $html_base->loadHTML($str);
  $links = $html_base->getElementsByTagName('a');

  $print = "";
  for ($i = 0; $i < $links->length; $i++) {
    $link = $links->item($i);
    $url =  $link->attributes->getNamedItem("href")->textContent;

    if (strpos($url, 'forum=scoops1') && strpos($url, 'az=read_count') && !strpos($url, "mm=") ) {
      $print .= '<div class="news-item">';
      $row = $link->parentNode->parentNode->parentNode->parentNode;
      $row->removeChild($row->firstChild->nextSibling->nextSibling->nextSibling);
      $row->removeChild($row->firstChild->nextSibling->nextSibling->nextSibling);
      $row->removeChild($row->firstChild->nextSibling->nextSibling->nextSibling);
      $print .=  innerXML($row);
      $print .=  '</div>';
    }
  }
  return $print;
}
?>
</div>


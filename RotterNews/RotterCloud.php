<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 27/01/15
 * Time: 3:54 PM
 */

/**
 * Create a tag cloud from the news' titles.
 * @param $text
 * @return string
 */
function rotternews_get_tag_cloud($text) {
  // Get words.
  $text = str_replace(RotterInfo::$tag_clean_chars, '', $text);
  $words = explode(' ', $text);

  // Filter common words.
  $filtered_words = rotternews_filter_tags($words);
  $words_frequency = rotternews_word_frequency($filtered_words);

  $tags = 0;
  $cloud = '<div class="cloud">';

  /* This word cloud generation algorithm was taken from the Wikipedia page on "word cloud"
     with some minor modifications to the implementation */

  $font_max = 26;
  $font_min = 10;
  $frequency_min = 2;
  $frequency_max = 200; /* Frequency upper-bound */

  foreach ($words_frequency as $word => $frequency) {
    if ($frequency >= $frequency_min) {
      $font_size = floor(($frequency_max * ($frequency - $frequency_min)) / ($font_max - $font_min));
      // Define a color index based on the frequency of the word.
      $color = 'red';

      if ($font_size >= $font_min) {
        $link = '<a href="javascript:applySearch(' . "'" . rotter_cloud_alter_search_word($word) . "'" . ')">' . $word . '</a>';
        $cloud .= "<span style=\"font-size: " . $font_size  . "px; color: $color;\">" . $link . "</span> ";
        $tags++;
      }
    }

  }
  $cloud .= "</div>";

  return $cloud;
}

/**
 * Filter words that should not appear as tags.
 * @param $words
 * @return mixed
 */
function rotternews_filter_tags($words) {

  foreach ($words as $pos => $word) {
    trim($word);
    if (!in_array(strtolower($word), RotterInfo::$tag_filter, TRUE)
        && !is_numeric($word) && !empty($word)) {
      $filtered_words[$pos] = iconv("ISO-8859-8", "UTF-8", (iconv("UTF-8", "ISO-8859-8", $word)));
    }
  }

  return $filtered_words;
}

/**
 * Builds an array of words as keys and their frequency as the value. (case-insensitive)
 *
 * @param $words
 * @return array
 */
function rotternews_word_frequency($words) {

  $frequency_list = array();
  foreach ($words as $pos => $word) {

    $word = strtolower($word);
    if (array_key_exists($word, $frequency_list)) {
      ++$frequency_list[$word];
    }
    else {
      $frequency_list[$word] = 1;
    }

  }
  return $frequency_list;
}

/**
 * Filter out words below a specific frequency.
 *
 * @param $words
 * @param int $filter
 * @return array
 */
function rotternews_freq_filter($words, $filter = 0) {

  return array_filter(
    $words,
    function($v) use($filter) {
      if ($v >= $filter) return $v;
    }
  );
}

/**
 * Alter common words to a possible match for the search box.
 * @param $word
 * @return string
 *  Altered word.
 */
function rotter_cloud_alter_search_word($word) {
  $word = str_replace( array_keys(RotterInfo::$search_words), RotterInfo::$search_words, $word);
  return $word;
}

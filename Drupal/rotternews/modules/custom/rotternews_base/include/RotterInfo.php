<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 29/12/14
 * Time: 12:09 PM
 */

/**
 * Class RotterInfo
 * Hold information for rotter news.
 */
class RotterInfo {
  public static $encoding ='UTF-8';
  public static $version = "0.43";
  public static $base_url = "http://rotter.net/scoopscache.html";
  public static $default_sort = "time";

  public static $search_words = array(

  );

  public static $tag_filter = array(
    'של', 'עכשיו', 'על', 'לא', 'את', 'זה', 'כי', 'נגד', 'עד', 'עם', 'עקב', 'פרסום', 'יש', 'בן', 'כדי',
  );
  public static $tag_clean_chars = array(
    ':', '.', '(', ')', ",", "-", "\t", "\n", "\\", "/",
  );

  public static $image_removal_hints = array(
    "avatar",
    "customavatars",
    "images/avatars/",
    "icon",
    "emoticons",
    "signatures",
    "customprofilepics",
    "images/spacer.gif",
    "profilepic",
    "549aa5804f857de3.jpg",
    "52ca876d7968bae3.jpg",
    "525c058f0591e560.jpg",
    "4b1981771fe41d21.jpg",
    "pmwiki/pub/images/Slig",
    "imgur.com/9wkXNzq.png",
    "rotter.net/forum/Images/oranis/set1_14.gif",
    "animated-gifs.",
    "al-magor.com/wp-content/uploads/2012/08/rifle_sight-150x150.jpg",
    "pinchas.net",
    "tinypic.com/2mo9eag.jpg",
		"wikipedia/commons/9/91/Mossad_seal.png",
  );

  // Cleanup strings.
  public static $replace_strings = array(
    // Remove internal styles.
    'style="' => '"',
    'color="' => '"',
    '<b>' => '',
    'width="' => 'width="100%" "',
    'width:' => 'width:100%;',
    // Width thingy.
    '<font>' => "",
    '</font>' => '',
    '<td>' => "",
    '</td>' => '',
    '<table>' => "",
    '</table>' => '',
    'size=' => '',
  );

  /**
   * Gets an error message according to a code.
   * @param integer
   *  Error code.
   * @return string
   * Error message when failing to load request.
   */
  public static function _get_error_message($code = 0) {
    $error_message = "Error retrieving data.";
    switch ($code) {
      default:
        //TODO
    }


    return '<div class="news-container odd">
            <div class="news-item">' .
            $error_message .
            '</div>
          </div>';
  }
};

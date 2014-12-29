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

  public static $version = "0.42";
  public static $base_url = "http://rotter.net/scoopscache.html";
  public static $default_sort = "time";

  public static $image_removal_hints = array(
    "avatar",
    "customavatars",
    "images/avatars/",
    "signatures",
    "customprofilepics",
    "images/spacer.gif",
    "profilepic",
    "549aa5804f857de3.jpg",
    "52ca876d7968bae3.jpg",
    "pmwiki/pub/images/Slig",
    "rotter.net/forum/Images/oranis/set1_14.gif",
    "animated-gifs.",
    "emoticons",
    "al-magor.com/wp-content/uploads/2012/08/rifle_sight-150x150.jpg",
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
  );

  /**
   * @return string
   * Error message when failing to load request.
   */
  public static function _get_error_message() {
    return '<div class="news-container odd">
            <div class="news-item">
              Error retrieving data.
            </div>
          </div>';
  }
};

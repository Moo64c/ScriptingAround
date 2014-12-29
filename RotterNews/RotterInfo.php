<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 29/12/14
 * Time: 12:09 PM
 */

/**
 * Class RotterInfo
 * Hold string information about string cleaning.
 */
class RotterInfo {

  public static $image_removal_hints = array(
    "avatar",
    "images/avatars/",
    "forum/signatures",
    "customprofilepics",
    "http://rotter.net/forum/Images/spacer.gif",
    "http://rotter.net/User_files/forum/549aa5804f857de3.jpg",
    "/profilepic",
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
    // Signatures.
    'customprofilepics' => '',
    "pmwiki/pub/images/Slig" => '',
  );
};

<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<!--Header content-->
<header id="header">
  <div id="messages">
    <?php print $messages; ?>
  </div>
  <?php if ($tabs && user_access('administer content')): ?>
    <div class="tabs">
      <?php print render($tabs); ?>
    </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-lg-7 col-md-8  upper_links">
      <ul>
        <li class="search">
          <form action="<?php print $base_url; ?>search">
            <input name="search_api_views_fulltext" class="search-input" type="text">
          </form>
          <a>
            <img src="<?php print $images_path; ?>search.png" alt="<?php print t('Search'); ?>"/>
          </a>
          <div class="bottom-line"></div>
        </li>
        <li class="fb-likes">
          <div class="fb-like" data-href="http://hebrew.cri.cn/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
        </li>
        <li class="youtube">
          <a href="https://www.youtube.com/user/CRIHebrew" target="_blank">
            <img src="<?php print $images_path; ?>youtube.png" alt="<?php print t('YouTube'); ?>"/>
          </a>
          <div class="bottom-line"></div>
        </li>
        <li class="fb">
          <a href="https://www.facebook.com/crihebrew" target="_blank">
            <img src="<?php print $images_path; ?>fb.png" alt="<?php print t('Facebook'); ?>"/>
          </a>
          <div class="bottom-line"></div>
        </li>
        <li class="text-link">
          <a href="<?php print $base_url;?>about">
            <?php print t('אודות'); ?>
          </a>
          <div class="bottom-line"></div>
        </li>
      </ul>
    </div>
    <div class="col-lg-5 col-md-4 logo">
      <a href="<?php print $base_url;?>">
        <span class="logo-text"> <?php print t('CRI&bull;Online'); ?></span>
        <?php print t('מהדורת ישראל'); ?>
      </a>
    </div>
  </div>
  <div class="row main-nav">
    <div class="container">
      <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs"></div>
        <div class="col-lg-7 col-sm-9 col-xs-6">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only"><?php print t('תפריט') ?></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse">
            <nav role="navigation">
              <?php print $menu; ?>
            </nav>
          </div>
        </div>
        <div class="col-sm-3 col-xs-6">
          <p><a href="#"> <?php print t('עכשיו בסין'); // should be some variable with title; ?></a></p>
        </div>
      </div>
    </div>
  </div>
</header>
<div class="row">
  <div class="sidebar-container">
    <div class="col-md-0-5 right-menu menu-invert pull-right" id="sidebar">
      <div class="side front">
        <div class="panel panel-default" >
          <div class="panel-heading" id="sidebar-head-front">
            <a><img class="img-responsive" src="<?php print $images_path; ?>hide-red.png" id="hide-red-front"></a>
          </div>
          <div class="panel-body">
            <ul>
              <li><a id="panel-toggle" class="flip"><?php print t('שימושי בסי'); ?>ן <div class="arrow-right"></div></a></li>
              <li class="one-row"><a><?php print t('מפה'); ?> <div class="arrow-right"></div></a></li>
              <li><a href="<?php print $base_url;?>videos"><?php print t('מדור וידאו'); ?> <div class="arrow-right"></div></a></li>
              <li><a href="<?php print $base_url;?>images"><?php print t('מדור תמונות'); ?> <div class="arrow-right"></div></a></li>
              <li><a href="<?php print $base_url;?>writers"><?php print t('כותבים אורחים'); ?> <div class="arrow-right"></div></a></li>
              <li><a><?php print t('לוח אירועים'); ?> <div class="arrow-right"></div></a></li>
            </ul>
          </div>
          <div class="panel-footer">
            <p><a href="#"><?php print t('הפינה הסינית'); ?></a></p>
          </div>
        </div>
      </div>
      <div class="side back">
        <div class="panel panel-default" >
          <div class="panel-heading" id="sidebar-head-back">
            <a><img class="img-responsive" src="<?php print $images_path; ?>hide.png" id="hide-red-back"></a>
          </div>
          <div class="panel-body">
            <ul>
              <li><a href="#"><?php print t('סידורי ויזה'); ?> <div class="arrow-right"></div></a></li>
              <li class="one-row"><a><?php print t('סין עם ילדים'); ?> <div class="arrow-right"></div></a></li>
              <li><a href="<?php print $base_url;?>videos"><?php print t('לינה ודירות'); ?> <div class="arrow-right"></div></a></li>
              <li><a href="<?php print $base_url;?>images"><?php print t('חופשות וחגים'); ?> <div class="arrow-right"></div></a></li>
              <li><a href="<?php print $base_url;?>writers"><?php print t('תחבורה'); ?> <div class="arrow-right"></div></a></li>
              <li><a><?php print t('טלפונים שימושיים'); ?> <div class="arrow-right"></div></a></li>
            </ul>
          </div>
          <div class="panel-footer">
            <a class="flip"><?php print t('חזור'); ?> </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php print render($page['content']);  ?>
</div>
<div class="wrapper">
  <div id="footer">
    <?php print render($page['footer']); ?>
  </div>
</div>

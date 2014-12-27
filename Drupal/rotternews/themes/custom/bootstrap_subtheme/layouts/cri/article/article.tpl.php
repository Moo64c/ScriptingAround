<section class="homepage">
  <div class="container article">
    <div class="row main">
      <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0 pull-left page-content">
        <form class="search-form ">
          <input type="button" class="clear">
          <input type="button" class="follow">
          <input type="button" class="like">
          <span class="form-name">חיות מחמד של התה</span>
        </form>
        <div class="row content">
          <div class="col-md-8 pull-right">
            <div class="text-content card info pull-right">
              <ul calss="article-section">
                <li class="tea-section">
                  <?php print $map_link; ?>
                  <div class="map pull-left"><a href="<?php print $map_link; ?>"><?php print $content['map']; ?></a>
                    <div class="map-caption caption ">עבור למפה</div>
                  </div>
                  <?php print $body; ?>
                </li>
              </ul>
              <div class="content-border"></div>
              <div class="row article-tags pull-right">
                <div class="col-md-12">
                  <div class="article-tags-text">תגיות</div>
                  <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                      <!-- Brand and toggle get grouped for better mobile display -->
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                      </div>
                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="nav navbar-nav tag-links navbar-right">
                          <?php print $tags; ?>
                        </div>
                      </div>
                    </div>
                  </nav>
                  <div class="tell-us pull-right">
                    <?php print $report_link; ?>
                  </div>
                </div>
              </div>
              <div class="row social-networks pull-left">
                <div class="col-md-12">
                  <div class="shear-text">שיתוף</div>
                  <nav class="navbar navbar-default" role="navigation">

                    <div class="container-fluid">
                      <!-- Brand and toggle get grouped for better mobile display -->
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                      </div>

                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                        <?php print $social_links; ?>
                      </div>
                    </div>
                  </nav>
                </div>
              </div>
              <div class="fb-comments" data-href="http://hebrew.cri.cn/" data-numposts="5" data-colorscheme="light"></div>
            </div>
          </div>
          <div class="col-md-4 pull-left">
            <?php print $content['related_articles']; ?>
          </div>
        </div>
        <?php print $content['footer']; ?>
      </div>
    </div>
  </div>
</section>

<section class="homepage">
  <div class="container">
    <div class="row main">
      <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0 page-content nonpadding">
        <div class="row content">
          <div class="col-md-8 info">
            <div class="row">
              <div class="col-sm-4">
                <ul class="left-column">
                  <li>
                    <a href="<?php print $base_url; ?>images">
                      <img src="<?php print $images_path; ?>food/lotos1.jpg" class="img-responsive small-image">
                      <div class="information">
                        <p class="caption">
                          סין בבתמונות
                        </p>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-sm-4">
                <ul class="mid-column">
                  <li>
                    <a href="<?php print $base_url; ?>videos">
                      <img src="<?php print $images_path; ?>food/lotos1.jpg" class="img-responsive small-image">
                      <div class="play"></div>
                      <div class="information">
                        <p class="caption">
                          סין ב-you tube
                        </p>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-sm-4">
                <ul class="right-column">
                  <li>
                    <a href="<?php print $base_url; ?>map">
                      <img src="<?php print $images_path; ?>food/map.jpg" class="img-responsive small-image">
                        <span class="page-mark cyan-page">
                            טיולים
                        </span>
                      <div class="triangle"></div>
                      <div class="information">
                        <p class="caption">
                          סין במפה
                        </p>
                        <span class="description">
                          כמה מילים ממוקדות שהולכות לתאר מה הגולש הולך לראות כאן
                        </span>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <?php print $content['news_articles']; ?>
          </div>
          <div class="col-md-4 bigcol">
            <?php print $content['promoted_articles']; ?>
            <?php print $content['footer']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

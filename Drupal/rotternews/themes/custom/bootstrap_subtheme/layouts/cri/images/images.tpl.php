<section class="homepage">
  <div class="container photopage">
    <div class="main">
      <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0 page-content nonpadding">

        <?php print $content['search_bar']; ?>

        <div class="row content">
          <div class="col-md-8 info navbar-column">
            <div class="navbar-content">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-content">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>
              <div class="navbar-collapse collapse nav-content">
                <nav role="navigation">
                  <?php print $content['image_categories']; ?>
                </nav>
              </div>
            </div>

            <?php print $content['articles']; ?>
          </div>
          <div class="col-md-4 bigcol nonrightpad">
            <?php print $content['map']; ?>
            <?php print $content['footer']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

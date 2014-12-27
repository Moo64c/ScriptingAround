<section class="homepage">
  <div class="container writerpage">
    <div class="row main">
      <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0 page-content nonpadding">
        <?php print $content['top_bar'] ?>
        <div class="row content">
          <div class="col-md-4 bigcol cards pull-right nonrightpad">
            <ul>
              <li>
                <?php print $content['writer_card']; ?>
              </li>
            </ul>
            <?php print $content['footer']; ?>
          </div>
          <div class="col-md-8 col-xs-12 pull-left info">
            <div class="row">
              <?php print $content['writer_related_articles']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

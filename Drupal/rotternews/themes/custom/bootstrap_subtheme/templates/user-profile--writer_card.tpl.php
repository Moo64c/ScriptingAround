<div class="row card">
  <div class="col-md-5 pull-right">
    <?php print $photo; ?>
  </div>
  <div class="col-md-7 col-xs-6">
    <p class="about-text pull-right">
      <?php print $information; ?>
    </p>
  </div>
</div>
<div class="row about-signature">
  <a href="<?php print $facebook;?>">
    <div class="information">
      <div class="caption">
        <img class="img-responsive pull-left fb-image" src="<?php print $images_path;?>fb-white.png" alt="">
        <span class="about-personal-name">
          <?php print $name; ?>
        </span>
      </div>
    </div>
  </a>
</div>

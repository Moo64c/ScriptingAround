<?php

if ($url = $_GET['sig']) {
  $image = imagecreatetruecolor(150, 30);
  $text_color = imagecolorallocate($image, 233, 14, 91);
  imagestring($image, 1, 5, 5,  'AmirNews v0.2', $text_color);
  imagestring($image, 1, 5, 20,  'Removes signature images!', $text_color);

  // Set the content type header - in this case image/png
  header('Content-Type: image/png');
  imagepng($image);
}

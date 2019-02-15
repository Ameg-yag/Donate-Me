<?php

function stripMetaImagick($file)
{
  $file = 'storage/app/public/' . $m->image
  $i = new Imagick($file);
  $i->setImageResolution(640,360);
  $profiles = $i->getImageProfiles("icc", true);
  $i->setImageCompression(Imagick::COMPRESSION_JPEG);
  $i->setImageCompressionQuality(70);
  $i->setImageFormat("jpg");
  $i->stripImage();
  if(!empty($profiles))
    $i->profileImage("icc", $profiles['icc']);
  $i->writeImage($file);
}

function stripMetaGD($file)
{
  $img = imagecreatefromjpeg ($file);
  imagejpeg ($img, $file, 95);
  imagedestroy ($img);
}

<?php
function phpHasGD(){
  return (extension_loaded('gd') && function_exists('gd_info'));
}

function phpHasImagick(){
  return (extension_loaded('imagick'));
}

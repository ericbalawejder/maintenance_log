<?php

$images_dir = "images/gallery";

function getFilesFrom($dir) {
  $omit=array(".","..");
  $files = array();
  if ($handle = opendir($dir)) {
    while (($entry = readdir($handle)) !== false) {
      if (!in_array($entry, $omit)) {
        $files[] = $entry;
      }
    }
    closedir($handle);
  } else {
    throw new Exception("cannot open directory: $dir");
  }
  return $files;
}

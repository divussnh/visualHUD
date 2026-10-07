<?php
// Runtime settings, read from environment variables so the same code runs
// on the hosted site and on a local machine.
//
//   VHUD_TEMP_DIR  Directory for generated zip files (created if missing).
//                  Default: <system temp dir>/visualhud
//   VHUD_DB_HOST, VHUD_DB_USER, VHUD_DB_PASS, VHUD_DB_NAME
//                  MySQL settings for the downloads counter. When VHUD_DB_HOST
//                  is unset the counter is disabled and downloads still work.

function vhud_temp_dir() {
  $dir = getenv('VHUD_TEMP_DIR');
  if ($dir === false || $dir === '') {
    $dir = sys_get_temp_dir() . '/visualhud';
  }
  $dir = rtrim($dir, '/\\');
  if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
  }
  return $dir . '/';
}
?>

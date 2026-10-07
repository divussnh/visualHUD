<?php
include_once(__DIR__ . '/config.php');

$db = null;

if (getenv('VHUD_DB_HOST') && function_exists('mysqli_connect')) {
  mysqli_report(MYSQLI_REPORT_OFF);
  $db = @mysqli_connect(
    getenv('VHUD_DB_HOST'),
    getenv('VHUD_DB_USER') ?: 'visualhud',
    getenv('VHUD_DB_PASS') ?: '',
    getenv('VHUD_DB_NAME') ?: 'visualhud'
  );
  if (!$db) {
    # do nothing. We still should be able to download config.
    $db = null;
  }
}

function initialize_counter() {
  global $db;
  if (!$db) { return false; }

  $count = count(glob(vhud_temp_dir() . "*.zip"));

  $query = "INSERT INTO downloads_count (`name`, `count`) VALUES ('downloads' , $count) ON DUPLICATE KEY UPDATE `count` =  $count";
  mysqli_query($db, $query) or die("Query error!");
  if (mysqli_affected_rows($db) > 0 ) { return true; }
  return false;
}

function increment_downloads_counter() {
  global $db;
  if (!$db) { return false; }

  $query = "INSERT INTO downloads_count (`name`, `count`) VALUES ('downloads' , 1) ON DUPLICATE KEY UPDATE `count` = `count` + 1";
  mysqli_query($db, $query) or die("Query error!");
  if (mysqli_affected_rows($db) > 0 ) { return true; }
  return false;
}

function get_downloads_counter() {
  global $db;
  if (!$db) { return 0; }

  $query = "SELECT `count` FROM downloads_count WHERE `name` = 'downloads'";
  $resource = mysqli_query($db, $query) or die("Query error!");
  $result = mysqli_fetch_assoc($resource);
  return $result ? $result['count'] : 0;
}
?>

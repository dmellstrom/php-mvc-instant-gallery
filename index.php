<?php

// User-defined constants
define("GALLERY_ROOT",      '/');
define("GALLERY_TITLE",     'Gallery');
define("THUMBNAIL_WIDTH",   200);
define("THUMBNAIL_HEIGHT",  200);
define("THUMBNAIL_QUALITY", 100);
define("THUMBNAIL_CROP",    true);
define("LIGHTBOX_SHOW",     true);

// System-defined constants
define("TEMPLATE_FILE",     'template.php');
define("FULLS_PATH",        'images/fulls/');
define("THUMBS_PATH",       'images/thumbs/');
define("REAL_BASE",         realpath(FULLS_PATH));

spl_autoload_register(function ($class_name) {
    include './models/' . $class_name . '.php';
});

/******************************** SERVE THUMBNAIL ****************************/
if (isset($_GET['t'])) {
  $requested = trim($_GET['t']);
  $thumb = new Thumbnail($requested);
  if ($thumb->exists()) {
    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $thumb->getModified()) {
      header('HTTP/1.0 304 Not Modified');
      exit();
    }
    session_cache_limiter('');
    header('Content-Type: image/jpeg');
    header("Content-Length: " . filesize($thumb->getFilename()));
    header("Last-Modified: " . $thumb->getModified());
    readfile($thumb->getFilename());
    exit();
  } else {
    header('HTTP/1.0 404 Not Found');
    print('404 Not Found');
    exit();
  }
}

/******************************** SERVE INDEX ********************************/
// Generate file list
$path = FULLS_PATH;
$subpath = '';
$parent = '';
if (isset($_GET['p'])) {
  $subpath = trim($_GET['p']);
  $realpath = new Path($subpath);
  $parent = $realpath->getParent();
  $path = FULLS_PATH . $subpath;
  $subpath .= '/';
} else {
  $realpath = new Path($subpath);
}
if (!$realpath->isDir()) {
  die('Illegal path');
}
$gallery = new Gallery($path);
$subdirs = $gallery->getSubdirs();
$files = $gallery->getFiles();

// Render template
$title = GALLERY_TITLE;
$root = GALLERY_ROOT;
$fulls = FULLS_PATH;
$size = max(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
$lightbox = LIGHTBOX_SHOW;
header('Expires: Mon, 01 Jan 2018 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
ob_start();
include(TEMPLATE_FILE);
ob_start('ob_gzhandler');
print(ob_get_clean());
exit();
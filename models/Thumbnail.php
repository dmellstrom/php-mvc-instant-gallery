<?php
class Thumbnail
{
  private $filename;
  private $modified;

  public function __construct($requested)
  {
    new Path($requested); // Prevent directory traversal

    $file = FULLS_PATH . $requested;
    $thumbfile = THUMBS_PATH . $requested . '.jpg';

    if (is_file($file) && is_readable($file)) {

      if (!is_file($thumbfile) || (filemtime($file) > filemtime($thumbfile))) {
        $this->generateThumbnail($file, $thumbfile);
      }

      $this->filename = $thumbfile;
      $this->modified = date('D, d M Y H:i:s \G\M\T', filemtime($thumbfile));
      
    } else {
      if (is_file($thumbfile)) unlink($thumbfile);
    }
  }

  protected function generateThumbnail($file, $thumbfile) {
    $size = getimagesize($file);
    if (!isset($size)) {
      die("Unrecognized file format for $file");
    }
    $width = $size[0];
    $height = $size[1];
    if ($width == 0 || $height == 0) {
      $thumbwidth  = 0;
      $thumbheight = 0;
    } else {
      $ratio = (max($width, $height) /
                min($width, $height)) /
               (max(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT) /
                min(THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT));
      if (
         ($ratio >= 1.0 && THUMBNAIL_CROP == false && $width < $height)
      || ($ratio < 1.0 && THUMBNAIL_CROP == false && THUMBNAIL_WIDTH > THUMBNAIL_HEIGHT)
      || ($ratio >= 1.0 && THUMBNAIL_CROP == true && $width > $height)
      || ($ratio < 1.0 && THUMBNAIL_CROP == true && THUMBNAIL_WIDTH < THUMBNAIL_HEIGHT)
                ) {
        $thumbwidth  = round((THUMBNAIL_HEIGHT * $width) / $height);
        $thumbheight = THUMBNAIL_HEIGHT;
      } else {
        $thumbwidth  = THUMBNAIL_WIDTH;
        $thumbheight = round((THUMBNAIL_WIDTH * $height) / $width);
      }
    }
    switch ($size[2]) {
      case 1: $original = imagecreatefromgif($file); break;
      case 2: $original = imagecreatefromjpeg($file); break;
      case 3: $original = imagecreatefrompng($file); break;
      default: die("Unrecognized file format for $file");
    }
    $thumbnail = imagecreatetruecolor($thumbwidth, $thumbheight);
    imagecopyresampled($thumbnail, $original, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
    if (THUMBNAIL_CROP) {
      $x = ($thumbwidth - THUMBNAIL_WIDTH) / 2;
      $y = ($thumbheight - THUMBNAIL_HEIGHT) / 2;
      $thumbnail = imagecrop($thumbnail, ['x' => $x, 'y' => $y, 'width' => THUMBNAIL_WIDTH, 'height' => THUMBNAIL_HEIGHT]);
    }
    // Save thumbnail
    $basename = basename($thumbfile);
    $savedir = substr($thumbfile, 0, strlen($thumbfile) - strlen($basename));
    if (!is_dir($savedir)) {
      if (!mkdir($savedir, 0755, true)) {
        die('Failed to create thumbnail subdirectory');
      }
    }
    if (!imagejpeg($thumbnail, $thumbfile, THUMBNAIL_QUALITY)) {
      die('Failed to save thumbnail');
    }
    imagedestroy($original);
    imagedestroy($thumbnail);
  }

  public function exists() {
    return (isset($this->filename) && isset($this->modified));
  }

  public function getFilename() {
    return $this->filename;
  }

  public function getModified() {
    return $this->modified;
  }
}
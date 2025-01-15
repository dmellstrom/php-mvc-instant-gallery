<?php
class Path
{
  private $path;
  private $parent;

  public function __construct($path)
  {
    // Protect against directory traversal attacks
    $realpath = realpath(FULLS_PATH . $path);
    if (strpos($path, '..') !== false
        || $realpath == false
        || strpos($realpath, REAL_BASE) !== 0) {
      throw new \Exception("Illegal path");
    }
    $parent = '';
    if (strpos($path, '/') !== false) {
      // If it is a sub-subdirectory, provide the parent
      $parent = substr($path, 0, strrpos($path, '/'));
    }
    $this->path = $realpath;
    $this->parent = $parent;
  }

  public function getParent() {
    return $this->parent;
  }

  public function isDir() {
    return is_dir($this->path);
  }
}
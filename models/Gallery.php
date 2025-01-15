<?php
class Gallery
{
    private $subdirs;
    private $files;

    public function __construct($path)
    {
        $subdirs = array();
        $files = array();
        $folder = opendir($path);
        while (($file = readdir($folder)) !== false) {
            if ($file[0] == '.') {
                continue;
            }
            if (preg_match('#\.(jpe?g|png|gif|webp)$#i', $file)) {
                if (is_file($path . '/' . $file) && is_readable($path . '/' . $file)) {
                    $files[] = $file;
                }
            } else if (is_dir($path . '/' . $file) && is_readable($path . '/' . $file)) {
                $subdirs[] = $file;
            }
        }
        sort($subdirs);
        sort($files);
        $this->subdirs = $subdirs;
        $this->files = $files;
    }

    public function getSubdirs() {
        return $this->subdirs;
    }

    public function getFiles() {
        return $this->files;
    }
}
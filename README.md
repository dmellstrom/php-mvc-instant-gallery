# PHP MVC Instant Gallery

Generates a gallery index with thumbnails from a directory of images. Supports JPG, PNG, GIF, and subdirectories. Demonstrates OOP, MVC architecture, and autoloading.

## Requirements

PHP server with GD2 extension installed and enabled

## Basic Installation

To serve a gallery at the root of a domain or subdomain, simply deploy the contents of this repository to the relevant web folder and place the images to be displayed in the `fulls` directory.

## Advanced Configuration

Several constants can be edited at the top of `index.php` to customize the operation of the gallery:

* `GALLERY_ROOT`: In order to deploy the gallery in a subdirectory of your domain or subdomain, edit this constant to contain the relative URL of that subdirectory, including leading and trailing slashes. For example, if deploying to `example.com/gallery`, set the value of this constant to `/gallery/`.
* `GALLERY_TITLE`: The contents of this variable are displayed to the user in the page title.
* `THUMBNAIL_WIDTH` / `THUMBNAIL_HEIGHT`: Maximum size of generated thumbnails, in pixels.
* `THUMBNAIL_QUALITY`: JPEG output quality of generated thumbnails.
* `THUMBNAIL_CROP`: If set to `false`, generated thumbnails will have the same aspect ratio as the original images. Otherwise, the image will be center-cropped to fill the thumbnail.
* `LIGHTBOX_SHOW`: If set to `false`, thumbnails will link to the original images instead of launching a slideshow.
* `LIGHTBOX_LOOP`: Set this value to 1 to enable looping from the last image to the first in the slideshow, or 2 to enable bidirectional looping.
* `ANCHOR_TARGET`: Determines the behavior of thumbnail links in the absence of the lightbox. Set this to `_self` to open full images in the same tab (default is `_blank` for a new tab).
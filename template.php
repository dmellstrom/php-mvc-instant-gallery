<html>
<head>
  <title><?=$title?></title>
  <style type="text/css"><!--
    body {
      background-color: silver;
      font-family: sans-serif;
    }
    a, a:visited {
      color: black;
    }
    .item {
      width: <?=$size?>px;
      height: <?=$size?>px;
      margin: 10px;
      padding: 20px;
      display: inline-block;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      float: left;
      background-color: black;
      font-size: 1.5em;
    }
    .folder {
      width: <?=(0.9 * $size)?>px;
      height: <?=(0.9 * $size)?>px;
      border-radius: 0 10px 10px 10px;
      line-height: 2em;
      background-color: silver;
      border-top: 5px solid gray;
      position: relative;
    }
    .folder:before {
      content: '';
      width: 50%;
      height: 15px;
      border-radius: 10px 20px 0 0;
      background-color: silver;
      position: absolute;
      top: -15px;
      left: 0px;
    }
    .folder span {
      display: block;
      width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  //--></style>
</head>
<body>
  <div class="container">
    <div class="gallery">
      <?php if($subpath): ?>
        <h2>Contents of <?=$root?><?=htmlspecialchars($subpath)?></h2>
        <div class="item">
          <?php if($parent): ?>
          <a href="<?=$root?>index.php?p=<?=$parent?>">
          <?php else: ?>
          <a href="<?=$root?>">
          <?php endif; ?>
            <div class="folder">
              <span>^ [Up one level]</span>
            </div>
          </a>
        </div>
      <?php else: ?>
        <h2>Contents of <?=$root?></h2>
      <?php endif; ?>

      <?php if(count($subdirs)): ?>
        <?php foreach($subdirs as $subdir): ?>
          <div class="item">
            <a href="<?=$root?>index.php?p=<?=$subpath?><?=htmlspecialchars($subdir)?>">
              <div class="folder"><span><?=htmlspecialchars($subdir)?><span></div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if(count($files)): ?>
        <?php foreach($files as $i => $file): ?>
          <div class="item">
            <?php if($lightbox): ?>
            <a href="#<?=($i + 1)?>">
            <?php else: ?>
            <a href="<?=$root?><?=$fulls?><?=htmlspecialchars($subpath)?><?=htmlspecialchars($file)?>" target="<?=$target?>">
            <?php endif; ?>
              <img src="<?=$root?>index.php?t=<?=htmlspecialchars($subpath)?><?=htmlspecialchars($file)?>"
                   alt="<?=$file?>"
                   border="0" />
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <?php if($lightbox && count($files)): ?>
    <!-- Prevent FOUC -->
    <style type="text/css"><!--
      .lightbox {
        visibility: hidden;
      }
      .lightbox .lightbox-image-container {
        display: none;
      }
    //--></style>
    <link rel="stylesheet" type="text/css" href="lightbox.css">
    <?php foreach($files as $i => $file): ?>
      <div class="lightbox" id="<?=($i+1)?>">
        <h1><?=($i + 1)?>/<?=count($files)?></h1>
        <div class="lightbox-close">
          <a href="#_"></a>
        </div>
        <?php if($i > 0 || $loop == 2): ?>
        <div class="lightbox-prev">
          <a href="#<?=((($i - 1) + count($files)) % count($files) + 1)?>">
            <div>&lsaquo;</div>
          </a>
        </div>
        <?php endif; ?>
        <?php if($i < count($files) - 1 || $loop == 1 || $loop == 2): ?>
        <div class="lightbox-next">
          <a href="#<?=((($i + 1) % count($files)) + 1)?>">
            <div>&rsaquo;</div>
          </a>
        </div>
        <?php endif; ?>
        <div class="lightbox-wrapper">
          <div class="lightbox-image-container">
            <div class="lightbox-image" style="background-image:url(<?=$root?><?=$fulls?><?=htmlspecialchars($subpath)?><?=htmlspecialchars($file)?>)"></div>
            </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
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
        <h2>Contents of <?=htmlspecialchars($subpath)?></h2>
        <div class="item">
          <?php if($parent): ?>
          <a href="<?=$root?>index.php?p=<?=$parent?>">
          <?php else: ?>
          <a href="<?=$root?>">
          <?php endif; ?>
            <div class="folder">
              ^ [Up one level]
            </div>
          </a>
        </div>
      <?php else: ?>
        <h2>Gallery root</h2>
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
        <?php foreach($files as $file): ?>
          <div class="item">
            <a href="<?=$root?>fulls/<?=htmlspecialchars($subpath)?><?=htmlspecialchars($file)?>">
              <img src="<?=$root?>index.php?t=<?=htmlspecialchars($subpath)?><?=htmlspecialchars($file)?>"
                   alt="<?=$file?>"
                   border="0" />
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
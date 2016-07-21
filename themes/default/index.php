<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $PMS->getHomeTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $themePath; ?>css/master.css" media="screen" charset="utf-8">
  </head>
  <body>

    <header>
      <h1><?php echo $PMS->get("Name"); ?></h1>
    </header>

    <div class="content">
      <h2>About Me</h2>
      <?php echo $PMS->get("About Me"); ?>
    </div>

    <?php foreach($PMS->getPublicProjects() as $project){ ?>
      <div class="content">
        <h2><?php echo $project['title']; ?></h2>
        <?php echo nl2br($project['preview']); ?>
      </div>
    <?php } ?>

  </body>
</html>

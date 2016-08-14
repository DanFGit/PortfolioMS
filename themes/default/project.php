<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $PMS->getHomeTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $themePath; ?>css/master.css" media="screen" charset="utf-8">
  </head>
  <body>

    <header>
      <h1><a href="index.php"><?php echo $PMS->get("Name"); ?></a></h1>
    </header>

    <?php $project = $PMS->getProject($_GET['id']);

      if($project && $project['visible']){ ?>

        <div class="content">
          <h2><?php echo $project['title']; ?></h2>
          <?php echo nl2br($project['body']); ?>
        </div>

      <?php } else { ?>

        <div class="content">
          Error! Project <?php echo $_GET['id']; ?> Not Found<br>
          <a href="project.php">Click here to see my full list of projects</a>
        </div>

      <?php } ?>

  </body>
</html>

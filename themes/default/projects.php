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

    <?php foreach($PMS->getPublicProjects() as $project){ ?>

      <div class="content">
        <h2><a href="project.php?id=<?php echo $project['id']; ?>"><?php echo $project['title']; ?></a></h2>
        <?php echo nl2br($project['preview']); ?>
      </div>

    <?php } ?>

  </body>
</html>

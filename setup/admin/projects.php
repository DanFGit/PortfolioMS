<?php
  session_start();
  require('../classes/pms.class.php');
  $errors = [];
  $statuses = [];

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  //If user is logged in, check if any forms have been submitted
  if($isLoggedIn){
    if(isset($_POST['createProject'])){
      if($PMS->createProject($_POST['title'], $_POST['preview'], $_POST['body'], isset($_POST['visible'])))
        $statuses[] = ["success", "Project Created!"];
        else $statuses[] = ["error", "Could not create project, please try again or contact your system administrator."];
    } else if(isset($_GET['delete'])){
      if($PMS->deleteProject($_GET['delete']))
        $statuses[] = ["success", "Project Deleted!"];
        else $statuses[] = ["error", "Could not delete project, please try again or contact your system administrator."];
    } else if(isset($_POST['editProject'])){
      if($PMS->editProject($_GET['edit'], $_POST['title'], $_POST['preview'], $_POST['body'], isset($_POST['visible'])))
        $statuses[] = ["success", "Project Edited!"];
        else $statuses[] = ["error", "Could not edit project, please try again or contact your system administrator."];
    } else if(isset($_GET['hide'])){
      if($PMS->hideProject($_GET['hide']))
        $statuses[] = ["success", "Project is now hidden from the public!"];
        else $statuses[] = ["error", "Could not hide project, please try again or contact your system administrator."];
    } else if(isset($_GET['show'])){
      if($PMS->showProject($_GET['show']))
        $statuses[] = ["success", "Project is now visible to the public!"];
        else $statuses[] = ["error", "Could not show project, please try again or contact your system administrator."];
    } else if(isset($_POST['reorderProjects'])){
      $error = 0;
      foreach ($_POST['order'] as $id => $order)
        if(!$PMS->reorderProject($id, $order)) $error++;
      if($error == 0)
        $statuses[] = ["success", "Projects reordered successfully!"];
        else $statuses[] = ["error", "Could not reorder projects, please try again or contact your system administrator."];
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard - PortfolioMS</title>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <link href="css/master.css" rel="stylesheet">
  </head>
  <body>
    <?php require('nav.php'); ?>
    <?php if($isLoggedIn) { ?>
      <main>
        <?php foreach ($statuses as $status) { ?>
          <section>
            <p class='content <?php echo $status[0]; ?>'><?php echo $status[1]; ?></p>
          </section>
        <?php } ?>

        <?php if(!isset($_GET['edit'])) {
          $projectList = $PMS->getProjects(); ?>
          <section>
            <h2>Project List</h2>
            <div class="content">
              <?php foreach($projectList as $project) { ?>
                <div class="project<?php if(!$project['visible']) echo " hidden"; ?>">
                  <a class="button" href="projects.php?edit=<?php echo $project['id']; ?>">Edit</a>
                  <?php if($project['visible']) { ?>
                  <a class="button" href="projects.php?hide=<?php echo $project['id']; ?>">Hide</a>
                  <?php } else { ?>
                  <a class="button" href="projects.php?show=<?php echo $project['id']; ?>">Show</a>
                  <?php } ?>
                  <a class="button" href="projects.php?delete=<?php echo $project['id']; ?>">Delete</a>
                  <span class="title"><?php echo $project['title'] . "<br>"; ?></span>
                </div>
              <?php } ?>
            </div>
          </section>
          <?php if(count($projectList) > 0){ ?>
          <section>
            <h2>Re-order Projects</h2>
            <form id="reorderProjects" class="content" action="#" method="POST" autocomplete="off">
              <p>You can reorder projects here. They are ordered lowest to highest, so 1 is the first project people see, 2 would be next, then 3, and so on. Two projects with the same number will be ordered randomly.</p><br>
              <?php foreach($projectList as $project) { ?>
                <input type="text" name="order[<?php echo $project['id']; ?>]" value="<?php echo $project['sort']; ?>" class="order">
                <label for="order[<?php echo $project['id']; ?>]"><?php echo $project['title']; ?></label>
                <br>
              <?php } ?>
              <br>
              <input type="submit" class="submit" value="Re-order Projects" name="reorderProjects" />
            </form>
          </section>
          <?php } ?>
          <section>
            <h2>Create New Project</h2>
            <form id="createProject" class="content" action="#" method="POST" autocomplete="off">
              <label for="title">Project Title</label><br>
              <input type="text" name="title" /><br><br>
              <label for="preview">Short Description (shown on homepage)</label><br>
              <textarea name="preview" rows="4" cols="100"></textarea><br><br>
              <label for="body">Full Description (shown on project's page)</label><br>
              <textarea name="body" rows="8" cols="100"></textarea><br><br>
              <input type="checkbox" class="checkbox" name="visible" />
              <label for="visible">Project Visible to Public?</label><br><br>
              <input type="submit" class="submit" value="Create Project" name="createProject" />
            </form>
          </section>
        <?php } else {
          $project = $PMS->getProject($_GET['edit']); ?>
          <section>
            <h2>Edit Project</h2>
            <form id="editProject" class="content" action="#" method="POST">
              <label for="title">Project Title</label><br>
              <input type="text" name="title" value="<?php echo $project['title']; ?>" /><br><br>
              <label for="preview">Short Description (shown on homepage)</label><br>
              <textarea name="preview" rows="4" cols="100"><?php echo $project['preview']; ?></textarea><br><br>
              <label for="body">Full Description (shown on project's page)</label><br>
              <textarea name="body" rows="8" cols="100"><?php echo $project['body']; ?></textarea><br><br>
              <input type="checkbox" class="checkbox" name="visible" <?php if($project['visible']) echo "checked"; ?>/>
              <label for="visible">Project Visible to Public?</label><br><br>
              <input type="submit" class="submit" value="Edit Project" name="editProject" />
            </form>
          </section>
        <?php } ?>
      </main>
    <?php } else { ?>
      <main>
        <section>
          <h2>Access Denied</h2>
          <p class="content">
            You must be logged in to access this area.
          </p>
        </section>
      </main>
    <?php } ?>
  </body>
</html>

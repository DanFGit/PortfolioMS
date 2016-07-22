<?php
  session_start();
  require('../classes/pms.class.php');
  $errors = [];

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  //If user is logged in, check if any forms have been submitted
  if($isLoggedIn){
    if(isset($_POST['createProject'])){
      $creationStatus = $PMS->createProject($_POST['title'], $_POST['preview'], $_POST['body'], isset($_POST['visible']));
    } else if(isset($_GET['delete'])){
      $deletionStatus = $PMS->deleteProject($_GET['delete']);
    } else if(isset($_POST['editProject'])){
      $editStatus = $PMS->editProject($_GET['edit'], $_POST['title'], $_POST['preview'], $_POST['body'], isset($_POST['visible']));
    } else if(isset($_GET['hide'])){
      $hideStatus = $PMS->hideProject($_GET['hide']);
    } else if(isset($_GET['show'])){
      $showStatus = $PMS->showProject($_GET['show']);
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
        <?php if(isset($creationStatus) || isset($editStatus) || isset($deletionStatus) || isset($showStatus) || isset($hideStatus)){ ?>
          <section>
            <?php
            if(isset($creationStatus) && $creationStatus) {
              echo "<p class='content success'>Project created successfully</p>";
            } else if(isset($creationStatus) && !$creationStatus) {
              echo "<p class='content error'>Project creation failed. Please try again.</p>";
            }

            if(isset($editStatus) && $editStatus) {
              echo "<p class='content success'>Project edited successfully</p>";
            } else if(isset($editStatus) && !$editStatus) {
              echo "<p class='content error'>Project edit failed. Please try again.</p>";
            }

            if(isset($deletionStatus) && $deletionStatus) {
              echo "<p class='content success'>Project deleted successfully</p>";
            } else if(isset($deletionStatus) && !$deletionStatus) {
              echo "<p class='content error'>Project deletion failed. Please try again.</p>";
            }

            if(isset($showStatus) && $showStatus) {
              echo "<p class='content success'>Project is now visible to the public</p>";
            } else if(isset($showStatus) && !$showStatus) {
              echo "<p class='content error'>Project could not be shown. Please try again.</p>";
            }

            if(isset($hideStatus) && $hideStatus) {
              echo "<p class='content success'>Project is now hidden from the public</p>";
            } else if(isset($hideStatus) && !$hideStatus) {
              echo "<p class='content error'>Project could not be hidden. Please try again.</p>";
            }
            ?>
          </section>
        <?php } ?>

        <?php if(!isset($_GET['edit'])) { ?>
          <section>
            <h2>Project List</h2>
            <div class="content">
              <?php foreach($PMS->getProjects() as $project) { ?>
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
          <section>
            <h2>Create New Project</h2>
            <form id="createProject" class="content" action="#" method="POST">
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

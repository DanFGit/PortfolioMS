<?php
  session_start();
  require('../classes/pms.class.php');
  $errors = [];

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  //If user is logged in, check if any forms have been submitted
  if($isLoggedIn){
    if(isset($_POST['createField'])){
      $creationStatus = $PMS->createField($_POST['name'], $_POST['value'], $_POST['type']);
    } else if(isset($_POST['deleteField'])){
      $deletionStatus = $PMS->deleteField($_POST['id']);
    } else if(isset($_POST['updateField'])){
      $updateStatus = $PMS->updateField($_POST['id'], $_POST['value']);
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
        <?php if(isset($creationStatus) || isset($editStatus) || isset($deletionStatus)){ ?>
          <section>
            <?php
            if(isset($creationStatus) && $creationStatus) {
              echo "<p class='content success'>Field created successfully</p>";
            } else if(isset($creationStatus) && !$creationStatus) {
              echo "<p class='content error'>Field creation failed. Please try again with a different field name.</p>";
            }

            if(isset($updateStatus) && $updateStatus) {
              echo "<p class='content success'>Field updated successfully</p>";
            } else if(isset($updateStatus) && !$updateStatus) {
              echo "<p class='content error'>Field update failed. Please try again.</p>";
            }

            if(isset($deletionStatus) && $deletionStatus) {
              echo "<p class='content success'>Field deleted successfully</p>";
            } else if(isset($deletionStatus) && !$deletionStatus) {
              echo "<p class='content error'>Field deletion failed. Please try again.</p>";
            }
            ?>
          </section>
        <?php } ?>

        <section>
          <h2>Field List</h2>
          <div class="content">
            <?php foreach($PMS->getAdminFields() as $field) { ?>
              <div class="field">
                <form action="#" method="POST">
                  <input type="hidden" id="id" name="id" value="<?php echo $field['id']; ?>" />
                  <label for="value"><?php echo $field['name']; ?></label><br>
                  <?php if($field['type'] == "text") { ?><input type="text" id="value" name="value" value="<?php echo $field['value']; ?>" /><?php } ?>
                  <?php if($field['type'] == "textarea") { ?><textarea rows="6" cols="100" id="value" name="value"><?php echo $field['value']; ?></textarea><?php } ?>
                  <input type="submit" value="Update" name="updateField" />
                  <input type="submit" value="Delete" name="deleteField" /><br><br>

                </form>
              </div>
            <?php } ?>
          </div>
        </section>

        <section>
          <h2>Create New Field</h2>
          <form class="content" action="#" method="POST">
            <label for="name">Field Name</label><br>
            <input type="text" name="name" /><br><br>

            <label for="type">Field Type</label><br>
            <select name="type">
              <option value="text" selected>Small Textbox</option>
              <option value="textarea">Large Textarea</option>
            </select><br><br>

            <label for="value">Field Value</label><br>
            <input type="text" name="value" /><br><br>

            <input type="submit" class="submit" value="Create Field" name="createField" />
          </form>
        </section>
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

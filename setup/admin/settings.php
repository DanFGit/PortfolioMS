<?php
  session_start();
  require('../classes/pms.class.php');

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  if($isLoggedIn){
    if(isset($_POST['selectTheme'])){
      $themeDetails = json_decode(file_get_contents('../themes/' . $_POST['selected'] . '/theme.json'));
    } else if(isset($_POST['setTheme'])){
      foreach ($_POST['fields'] as $fieldType => $fieldsOfType) {
        if(substr($fieldType, 0, 5) == "array") $fieldType = "array";
        foreach ($fieldsOfType as $fieldName => $fieldValue) {
          //TODO: If field name already exists, update it; else, create a new one
          $PMS->createField($fieldName, $fieldValue, $fieldType);
        }
      }
      $PMS->setTheme($_POST['selected']);
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
        <?php if(isset($themeDetails)){ ?>
          <section>
            <h2><?php echo $themeDetails->name; ?></h2>
            <form method="post" action="#" class="content">
              <?php foreach ($themeDetails->fields as $fieldName => $fieldType) { ?>
                  <label><?php echo $fieldName; ?></label>
                  <?php if($fieldType == "text") { ?><input type="text" id="value" name="fields[<?php echo $fieldType; ?>][<?php echo $fieldName; ?>]" /><?php } ?>
                  <?php if($fieldType == "textarea") { ?><textarea rows="6" cols="100" id="value" name="fields[<?php echo $fieldType; ?>][<?php echo $fieldName; ?>]"></textarea><?php } ?>
                  <?php if(substr($fieldType, 0, 5) == "array") {
                    $numInArray = explode("-", $fieldType)[1];
                    for($i = 0; $i < $numInArray; $i++) {?>
                      <input type="text" id="value" name="fields[<?php echo $fieldType; ?>][<?php echo $fieldName; ?>][]" />
                  <?php } } ?>
                  <br><br>
              <?php } ?>
              <input type="hidden" name="selected" value="<?php echo $_POST['selected']; ?>">
              <input class="submit" type="submit" name="setTheme" value="Save Theme">
            </form>
          </section>
        <?php } ?>

        <section>
          <h2>Theme Selection</h2>
          <form method="post" action="#" class="content">
            <label for="selected">Select a Theme:</label>
            <select name="selected">
              <?php $files = scandir('../themes');
              foreach($files as $file){
                if ($file{0} == '.' || !is_dir('../themes/' . $file)) continue;
                if($file == $PMS->getTheme()) {
                  echo "<option selected value='$file'>$file</option>";
                } else {
                  echo "<option value='$file'>$file</option>";
                }
              } ?>
            </select>
            <br><br>
            <input class="submit" type="submit" name="selectTheme" value="Change Theme">
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

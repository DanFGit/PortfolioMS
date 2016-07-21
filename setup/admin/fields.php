<?php
  if($isLoggedIn){
    if(isset($_POST['updateField'])){
      $PMS->updateAdminField($_POST['fieldID'], $_POST['fieldValue']);
    } else if(isset($_POST['deleteField'])){
      $PMS->removeAdminField($_POST['fieldID']);
    } else if(isset($_POST['addField'])){
      $PMS->addAdminField($_POST['newField'], $_POST['newFieldType']);
    }
  }
?>

<h2>Field List</h2>
<?php
$fieldList = $PMS->getAdminFields();
foreach ($fieldList as $key => $field) { ?>
  <form action="#" method="post">
    <label for="<?php echo $field['name']; ?>"><?php echo $field['name']; ?></label><br>
    <input type="hidden" id="fieldID" name="fieldID" value="<?php echo $field['id']; ?>" />
    <?php if($field['type'] == "text") { ?><input type="text" id="fieldValue" name="fieldValue" value="<?php echo $field['value']; ?>" /><?php } ?>
    <?php if($field['type'] == "textarea") { ?><textarea rows="6" cols="100" id="fieldValue" name="fieldValue"><?php echo $field['value']; ?></textarea><br><?php } ?>
    <input type="submit" value="Update" name="updateField" />
    <input type="submit" value="Delete" name="deleteField" /><br><br>
  </form>
<?php } ?>

<form action="#" method="post">
  <h2>Add a new Field</h2>
  <label for="newField">Field Name</label><br>
  <input type="text" id="newField" name="newField" /><br><br>
  <label for="newFieldType">Field Type</label><br>
  <select id="newFieldType" name="newFieldType">
    <option value="text" selected>Small Textbox</option>
    <option value="textarea">Large Textarea</option>
  </select><br><br>
  <input type="submit" value="Add New Field" name="addField" /><br><br>
</form>

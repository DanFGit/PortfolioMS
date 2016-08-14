<?php

// Create the PortfolioMS instance
require("classes/pms.class.php");
$PMS = new PMS();

// Detect if setup has been completed
if(!$PMS->isSetup()) { ?>
  <p style="margin:10px;padding:10px;background:#f44;color:#fff;font-size:.75rem;">
    <b>Error:</b> PortfolioMS has not been setup yet. Please go to <a href="setup/" style="text-decoration:none;color:#8ff;">Setup</a> and follow the instructions.
  </p><?php
  exit;
}

// Get the selected theme
$theme = $PMS->getTheme();
if($theme == NULL) $theme = "default";
$themePath = "themes/$theme/";

// Get the specified project page or show a list of projects
if(isset($_GET['id'])) {
  require($themePath . "project.php");
} else {
  require($themePath . "projects.php");
}

// The footer can be removed at your discretion ?>
<footer style="text-align:center;opacity:.33;padding:3px;">
  Powered by <a href="https://github.com/DanFGit/PortfolioMS" target="_blank">PortfolioMS</a>.
</footer>

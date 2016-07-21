<?php
require("classes/pms.class.php");
$PMS = new PMS();

if(!$PMS->isSetup()) {
  ?><p style="margin:10px;padding:10px;background:#f44;color:#fff;font-size:.75rem;">
    <b>Error:</b> PortfolioMS has not been setup yet. Please go to <a href="setup/" style="text-decoration:none;color:#8ff;">Setup</a> and follow the instructions.
  </p><?php
  exit;
}

$theme = $PMS->getTheme();
if($theme == NULL) $theme = "default";
$themePath = "themes/$theme/";

require($themePath . "index.php");
?>

<footer style="text-align:center;opacity:.33;padding:3px;">
  Powered by <a href="https://github.com/DanFGit/PortfolioMS" target="_blank">PortfolioMS</a>.
</footer>

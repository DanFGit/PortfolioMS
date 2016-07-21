<div id="errors">
  <?php foreach ($errors as $error) {
    echo "<p>$error</p>";
  } ?>
</div>
<nav>
  <div id="logo">
    <a href="./">PortfolioMS<sup>BETA</sup></a>
  </div>
  <?php if(!$isLoggedIn) { ?>
    <div class="navSection">
      <form class="loginForm" action="index.php" method="POST">
        <label for="email">Email</label>
        <input type="text" name="email" required class="loginInput" />
        <label for="password">Password</label>
        <input type="password" name="password" required class="loginInput" />
        <input type="submit" value="Log In" name="loginForm" class="loginSubmit" />
      </form>
    </div>
  <?php } else { ?>
    <div class="navSection">
      <span class="welcome">Hello, <?php echo $_SESSION['user']; ?></span>
    </div>
    <div class="navSection">
      <a href="./">Admin Home</a>
      <a href="./projects.php">Projects</a>
      <a href="./fields.php">Fields</a>
      <a href="./settings.php">Settings</a>
    </div>
    <div class="navSection">
      <a href="./account.php">Account</a>
      <a href="./logout.php">Logout</a>
    </div>
  <?php } ?>
</nav>

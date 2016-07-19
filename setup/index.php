<?php
  session_start();
  // $_SESSION['key'] = "secret";
  require('../classes/db.class.php');
  $DB = new DB();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PortfolioMS Setup</title>
    <style media="screen">
      *{box-sizing:border-box;}
      body{font:1rem monospace;max-width: 555px;}
      p,form{padding:5px;border-left:4px #fff solid;}
      .error{border-color:#f88;}
      .success{border-color:#7f8;}
      .info{border-color:#ff8;}
      li{list-style-position:inside;}
      input.text{margin-top:4px;font:.8rem monospace;background:#ff8;border:1px solid #bb5;padding:2px;}
      input[type="submit"]{background:#7f8;border:1px solid #495;font:.8rem monospace;padding:2px 4px;cursor:pointer;}
      .help{color: #999;}
      form{margin:10px 0;}
      #passwordError{padding-left:3px;color:#f00;}
    </style>
  </head>
  <body>

    <h1>Welcome to PortfolioMS</h1>

    <?php if($DB->isSetup()) {
      echo "<p class=error><b>Error</b> - PortfolioMS is already setup on this server! Please delete this file for security reasons.<br><br>";
      echo "If you would like to re-setup PortfolioMS, please delete the PortfolioMS database and refresh this page.<br><br>";
      echo "If you would like to setup multiple instances of PortfolioMS on one server, please provide them with unique database names in their '<i>classes/db.class.php</i>' file.</p>";
      exit;
    } ?>

    <?php $placeholder = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10); ?>
    <form id=adminForm class=info autocomplete=off>
      <label for=adminInput>
        Please enter your desired directory for the Admin Dashboard.<br>
        <span class=help>
          It is recommended that this is not easy to guess, like '<i>admin</i>',
          as despite best efforts to secure login forms it is always safer to
          have fewer people that know where the login form is in the first place.
        </span>
      </label><br>
      <input type=text required name=admin class=text id=adminInput placeholder="Example: <?php echo $placeholder ?>"/><br><br>
      <input type=submit value="Create Admin Directory" /> at http://yourwebsite.com/<span id=liveDirectory><?php echo $placeholder ?></span>/
    </form>

    <form id=accountForm class=info autocomplete=off style=display:none; >
      Please create your admin account using email and password.<br><br>

      <label for=email>Email</label><br>
      <input type=email required name=email class=text id=emailInput /><br>

      <label for=password>Password</label><br>
      <input type=password required name=password class=text id=passwordInput /><br>

      <label for=passwordValidate>Retype Password</label><br>
      <input type=password required name=passwordValidate class=text id=passwordValidateInput /><span id=passwordError></span><br><br>
      <input type=submit value="Create Admin Account" />
    </form>

    <p id=successMessage class=success style=display:none;>
      PortfolioMS has been setup successfully. You can now use the Admin Dashboard to manage your new portfolio!
      Please delete this /setup/ directory to avoid any potential security threats.<br>
      Thank you for using PortfolioMS.
    </p>

    <script>

      //Reference to forms
      var adminForm = document.getElementById("adminForm");
      var accountForm = document.getElementById("accountForm");

      //Store Form Data
      var adminDirectory = null;
      var email = null;
      var password = null;

      //When admin form is clicked
      adminForm.onsubmit = function(event){
        event.preventDefault();

        //Store the form data
        adminDirectory = this.elements["adminInput"].value;

        //Delete the form
        this.style.height = this.clientHeight + "px";
        this.style.paddingTop = this.clientHeight / 2 - 10 + "px";
        this.innerText = "Done!";
        this.className = "success";

        accountForm.style.display = "block";

      }

      //When admin directory input is changed
      document.getElementById("adminInput").oninput = function(){
        document.getElementById("liveDirectory").innerText = this.value;
      }

      //When accout form is clicked
      var accountForm = document.getElementById("accountForm");
      accountForm.onsubmit = function(event){
        event.preventDefault();

        //Check if passwords match
        if(this.elements["password"].value != this.elements["passwordValidate"].value){
          this.className = "error";
          document.getElementById("passwordError").innerText = "Passwords do not match!";
        } else {
          email = this.elements["email"].value;
          password = this.elements["password"].value;

          //Delete the form
          this.style.height = this.clientHeight + "px";
          this.style.paddingTop = this.clientHeight / 2 - 10 + "px";
          this.innerText = "Done!";
          this.className = "success";

          //Start XHR
          setupPortfolio();
        }
      }

      function setupPortfolio(){
        function parseResponse(){
          if(this.status != 201){
            alert("Error " + this.status + ": " + this.responseText);
          } else {
            document.getElementById("successMessage").style.display = "block";
          }
        }

        var formData = new FormData();
        formData.append('adminDirectory', adminDirectory);
        formData.append('email', email);
        formData.append('password', password);

        var req = new XMLHttpRequest();
        req.addEventListener("load", parseResponse);
        req.open("POST", "setup.php");
        req.send(formData);
      }

    </script>

  </body>
</html>

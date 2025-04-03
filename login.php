<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap'>
  <link rel="stylesheet" href="login.css">
  <style>
    .error {
      color: red;
      font-size: 0.9em;
      display: none;
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="login_box">
      <div class="login-header">
        <span>Login</span>
      </div>
      <form id="loginForm" action="login_process.php" method="POST">
        <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">
        <div class="input_box">
          <input type="email" id="user" class="input-field" name="email" autocomplete="username">
          <label for="email" class="label">Email</label>
          <i class="bx bx-user icon"></i>
          <div style="display: none;" class="error" id="emailerror">Please enter a valid email address.</div>
        </div>
        <div class="input_box">
          <input type="password" id="pass" class="input-field" name="password" autocomplete="current-password">
          <label for="password" class="label">Password</label>
          <i class="bx bx-lock-alt icon"></i>
          <div style="display: none;" class="error" id="passerror">Password must be at least 6 characters long.</div>
        </div>
        <div class="input_box">
          <input type="submit" class="input-submit" value="Login">
        </div>

        <div class="register">
          <span>Don't have an account? <a href="register.php">Register</a></span>
        </div>
      </form>
    </div>
  </div>


  <!-- Custom JavaScript for form validation -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      document.getElementById('loginForm').addEventListener('submit', function(event) {
        //event.preventDefault(); // Prevent form submission

        // Example validation logic
        const email = document.getElementById('user').value;
        const password = document.getElementById('pass').value;
        console.log("Email:", email);
        console.log("password:", password);

        if (!emailPattern.test(email)) {
          document.getElementById('emailerror').style.display = 'block';
          console.log('Invalid email');
        } else {
          document.getElementById('emailerror').style.display = 'none';
          console.log('valid email');
        }
        if (password.length < 6) {
          document.getElementById('passerror').style.display = 'block';
          console.log('Invalid Password')
        } else {
          document.getElementById('passerror').style.display = 'none';
          console.log('valid Password');
        }
      });
    });
  </script>
</body>

</html>
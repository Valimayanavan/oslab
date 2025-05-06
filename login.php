<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "testdb", 4306);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"];

    // Prepare SQL statement to fetch user by email
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            header("Location: home.php"); // Redirect to home after successful login
            exit();
        } else {
            $_SESSION["error"] = "Invalid password. Please try again.";
        }
    } else {
        $_SESSION["error"] = "No account found with that email.";
    }

    $stmt->close();
    $conn->close();

    header("Location: login.php"); // Redirect back to login page
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Full page background */
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      background-size: cover;
      color: #fff;
    }

    /* Container for the login form */
    .container {
      background-color: rgba(0, 0, 0, 0.7); /* Dark semi-transparent background */
      padding: 40px;
      border-radius: 15px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease-in-out;
    }

    .container:hover {
      transform: translateY(-10px); /* Hover effect for the form */
    }

    /* Logo */
    .logo {
      font-size: 36px;
      font-weight: bold;
      color: #FFD60A;
      margin-bottom: 20px;
    }

    /* Input fields styling */
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #fff;
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #34C759;
    }

    /* Button styling */
    button {
      padding: 12px;
      width: 100%;
      background-color: #34C759;
      border: none;
      border-radius: 5px;
      color: #fff;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2e7d32;
    }

    /* Forgot password and signup link */
    .forgot, .signup {
      color: #fff;
      font-size: 14px;
      margin-top: 10px;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .forgot:hover, .signup:hover {
      color: #34C759;
    }

    /* Error message style */
    .error {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }

  </style>
</head>
<body>

  <form method="POST" action="login.php">
    <div class="container">
      <div class="logo">ALL IS WELL</div>

      <h2>Login</h2>

      <!-- Show error message if any -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required placeholder="Enter your email">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">

      <button type="submit">Log In</button>

      <p class="forgot">Forgot Password?</p>
      <p class="signup" onclick="goToSignup()">Create New Account</p>
    </div>
  </form>

  <script>
    function goToSignup() {
      window.location.href = "register.php";
    }
  </script>

</body>
</html>

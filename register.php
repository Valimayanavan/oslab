<?php
// Start the session
session_start();

// Connect to the MySQL database
$conn = new mysqli("localhost", "root", "", "testdb", 4306);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    // Check if the email is already registered
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        $_SESSION["error"] = "Email already registered.";
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $_SESSION["success"] = "Registration successful! You can now log in.";
            header("Location: login.php"); // Redirect to login page after successful registration
            exit();
        } else {
            $_SESSION["error"] = "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }

    // Close the database connection
    $check_email->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Same styling as the login page, just tweak the layout for registration */
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

    .container {
      background-color: rgba(0, 0, 0, 0.7);
      padding: 40px;
      border-radius: 15px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease-in-out;
    }

    .container:hover {
      transform: translateY(-10px);
    }

    .logo {
      font-size: 36px;
      font-weight: bold;
      color: #FFD60A;
      margin-bottom: 20px;
    }

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

    .error, .success {
      font-size: 14px;
      color: red;
      margin-top: 10px;
    }

    .success {
      color: green;
    }

  </style>
</head>
<body>

  <form method="POST" action="register.php">
    <div class="container">
      <div class="logo">ALL IS WELL</div>

      <h2>Create New Account</h2>

      <!-- Show success or error messages -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php elseif (isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>

      <label for="username">Username</label>
      <input type="text" id="username" name="username" required placeholder="Enter your username">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required placeholder="Enter your email">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">

      <button type="submit">Sign Up</button>

      <p class="signup" onclick="goToLogin()">Already have an account? Login</p>
    </div>
  </form>

  <script>
    function goToLogin() {
      window.location.href = "login.php";
    }
  </script>

</body>
</html>

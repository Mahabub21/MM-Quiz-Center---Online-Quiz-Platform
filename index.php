<?php
session_start(); 
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Platform Home</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <header class="hero">
    <div class="hero-content">
      <h1>Welcome to MM Quiz Center</h1>
      <h3>TEST YOUR WITS, LEARN WITH FUN!</h3>
      <p>Challenge yourself with a wide variety of quizzes. Improve your skills and track your progress!</p>
      <a href="#quizzes" class="btn-cta">Start Your Journey</a>
    </div>
  </header>

  <nav class="navbar">
    <ul class="nav-list">
      <li><a href="index.php">Home</a></li>
      <?php if ($isLoggedIn): ?>
        <li><a href="#dashboard">Dashboard</a></li>
      <?php endif; ?>
      <li><a href="#contact">Contact</a></li>
      <li><a href="#about">About</a></li>
    </ul>
  </nav>

  <section id="quizzes" class="quiz-section">
    <h2>Explore Quizzes</h2>
    <section class="quick-links">
      <div class="quick-link-card">
        <a href="#quizzes" class="quick-link">
          <h3>Quizzes</h3>
          <p>Start a quiz now</p>
        </a>
      </div>
      <div class="quick-link-card">
        <a href="file1/register-login.php" class="quick-link">
          <h3>Register</h3>
          <p>Create a new account</p>
        </a>
      </div>
      <div class="quick-link-card">
        <a href="file1/login.php" class="quick-link">
          <h3>Login</h3>
          <p>Access your account</p>
        </a>
      </div>
    </section>
  </section>

  <footer class="footer">
    <div class="footer-content">
      <div class="footer-column">
        <p>Address: 159/18/A-1 West Shawreapara, Mirpur, Dhaka 1216</p>
        <p>Phone: (+880) 0107141820</p>
        <p>Email: info@mmquizcenter.com</p>
        <div class="social-media">
          <a href="https://facebook.com/mmquizcenter" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/mmquizcenter" target="_blank"><i class="fab fa-twitter"></i></a>
          <a href="https://instagram.com/mmquizcenter" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="https://linkedin.com/company/mmquizcenter" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="footer-column">
        <div class="app-download">
          <a href="https://www.apple.com/app-store/" target="_blank" class="app-icon">
            <i class="fab fa-apple"></i> App Store
          </a>
          <a href="https://play.google.com/store" target="_blank" class="app-icon">
            <i class="fab fa-google-play"></i> Google Play
          </a>
        </div>
      </div>
    </div>
    <div class="footer-logo">
      <img src="photo/logo.png" alt="MM Quiz Center Logo" class="logo">
    </div>
    <p>&copy; 2023 MM Quiz Center. All Rights Reserved.</p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
      if (isLoggedIn) {
        document.getElementById("dashboard-link").style.display = "inline-block";
      }
    });
  </script>
</body>
</html>

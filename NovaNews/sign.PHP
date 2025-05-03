<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NovaNews | Sign In / Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #1b2029;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .auth-container {
      background-color: #212936;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 400px;
    }

    .form-control,
    .form-select {
      background-color: #2c3a4e;
      border: 1px solid #0dcaf0;
      color: white;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #0dcaf0;
      box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
    }

    .btn-primary {
      background-color: #0dcaf0;
      border: none;
      color: #000;
    }

    .btn-primary:hover {
      background-color: #31d2f2;
    }

    .logo {
      width: 80px;
      margin-bottom: 20px;
    }

    a {
      color: #0dcaf0;
    }
  </style>
</head>
<body>

  <img src="world-news.png" alt="NovaNews Logo" class="logo" />

  <div class="auth-container">
    <h3 class="text-center mb-4" id="formTitle">Sign In</h3>

    <!-- Login Form (not functional yet) -->
    <form id="loginForm">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <p class="mt-3 text-center">Don't have an account? <a href="#" onclick="toggleForm()">Sign up</a></p>
    </form>

    <!-- Sign Up Form -->
    <form id="signupForm" action="signup.php" method="POST">
        <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Role</label>
        <select class="form-select" name="role" required>
          <option value="reader">Reader</option>
          <option value="author">Author</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign Up</button>
      <p class="mt-3 text-center">Already have an account? <a href="#" onclick="toggleForm()">Sign in</a></p>
    </form>
  </div>

  <script>
    const loginForm = document.getElementById("loginForm");
    const signupForm = document.getElementById("signupForm");
    const formTitle = document.getElementById("formTitle");

    function toggleForm() {
      if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        signupForm.style.display = "none";
        formTitle.innerText = "Sign In";
      } else {
        loginForm.style.display = "none";
        signupForm.style.display = "block";
        formTitle.innerText = "Sign Up";
      }
    }
  </script>
</body>
</html>

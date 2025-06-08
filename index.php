<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Conference Reservation | Login</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet" />

<link rel="icon" href="photos/icon.jfif" type="image/png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Added jQuery -->
 
</head>
<body>
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card-login shadow-lg">
      <div class="header-section">
        <img src="photos/hepc.jpg" alt="HEPC Logo" class="rounded-circle">
        <div class="title-container">
          <h5>Online Conference Room Reservation</h5>
          <p>
            <i class="fas fa-calendar-check me-2"></i>
            Welcome to the Reservation System
          </p>
        </div>
      </div>
      
      <div class="card-body">
        <div id="messageContainer"></div>

        <form id="loginForm" method='POST' action='./ajax/log-inout.php?which=login'>
          <div class="mb-4">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-user text-muted"></i>
              </span>
              <input type="text" name='username' id="username" class="form-control border-start-0" placeholder="Enter your username" required>
            </div>
          </div>
          
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-muted"></i>
              </span>
              <input type="password" id="password" class="form-control border-start-0" name='password' placeholder="Enter your password" required>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <a href="" class="text-muted">Forgot password?</a>
          </div>

          <div class="text-center mb-2">
            <button type="submit" class="btn btn-primary btn-lg w-100 mb-2">
              <i class="fas fa-sign-in-alt me-2"></i>Log In
            </button>
            <a href="register.php" class="btn btn-secondary btn-lg w-100">
              <i class="fas fa-user-plus me-2"></i>Register
            </a>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer class="text-white text-center">
    <p class="mb-0">© 2025 Hayakawa Electronics (Phil.s). Corp. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
<script>
  document.getElementById('loginForm').addEventListener('submit',function(e){
        e.preventDefault();
        const fomData=new FormData(this);
        fetch(this.action,{
            method:this.method,
            body:fomData
        }).then(response => response.text())
        .then(data => {
            console.log(data);
            if(data=='1'){
                window.location.replace('home.php');
                //or the equivalent of the user page tbh; I bet we're gonna have to make an endpoint that rerouts the page based on the user's account type--if they're admin or not.
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    })
</script>

</html>

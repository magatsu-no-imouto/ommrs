<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="photos/icon.jfif" type="image/png">
  <link rel="stylesheet" href="css/register.css" />
  <title>Register | Conference Portal</title>
</head>
<body>
  <main class="register-wrapper">
    <section class="register-box">
      <h1 class="form-title">Create Your Account</h1>
      <form class="register-form" action='./ajax/x-insertForm.php?which=account' method="POST" id="fomm">

        <div class="form-group">
          <label for="fullname">Full Name</label>
          <input type="text" id="fullname" name="fullname" required />
        </div>

          <div class="form-group">
          <label for="email">Department</label>
          <input type="text" id="department" name="department" required />
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>

        <div class="form-group">
          <label for="confirm">Confirm Password</label>
          <input type="password" id="confirm" name="confirm" required />
        </div>

        <button type="submit">Register</button>

        <p class="form-links">
          Already have an account?
          <a href="index.php">Log in</a>
        </p>
      </form>
    </section>
  </main>
</body>
    <script>
        document.getElementById('fomm').addEventListener('submit',function(e){
        e.preventDefault();
        const fomData=new FormData(this);
        fetch(this.action,{
            method:this.method,
            body:fomData
        }).then(response => response.text())
        .then(data => {
            console.log(data);
            if(data=='1'){
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    })
    </script>
</html>

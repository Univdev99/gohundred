<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Font Awesome Icons -->
  <link href="/css/all.css" rel="stylesheet" type="text/css">
  <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="/css/signup.css" rel="stylesheet" type="text/css">

  <!-- Google Fonts -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet"> -->
  <!-- <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'> -->

  <!-- Plugin CSS -->
  <!-- <link href="/css/magnific-popup.css" rel="stylesheet"> -->

  <!-- Theme CSS - Includes Bootstrap -->
  <!-- <link href="/css/creative.css" rel="stylesheet"> -->

</head>


<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<body>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body">
            <h5 class="card-title text-center">Sign in</h5>
            <form class="form-signin">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required>
                <label for="inputEmail">Email address</label>
              </div>
              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              <hr>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
              <p class="text-center mt-2">Don't have an account?</p>
              <a class="d-block text-center small" href="/signup">Sign up</a>
              <hr class="my-4">
              <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign in with Google</button>
              <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

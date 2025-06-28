<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form</title>
  <link rel="stylesheet" href="assets/css/loginStyle.css" />
</head>
<body>

  <form class="form" autocomplete="off">
    <div class="control">  
      <h1>Sign In</h1>
    </div>

    <div class="control block-cube block-input">
      <input name="email" id="email"  type="email" placeholder="Email" />
      <div class="bg-top">
        <div class="bg-inner"></div>
      </div>
      <div class="bg-right">
        <div class="bg-inner"></div>
      </div>
      <div class="bg">
        <div class="bg-inner"></div>
      </div>
    </div>

    <div class="control block-cube block-input">
      <input value="Aleksa123!" name="password" id="password" type="password" placeholder="Password" />
      <div class="bg-top">
        <div class="bg-inner"></div>
      </div>
      <div class="bg-right">
        <div class="bg-inner"></div>
      </div>
      <div class="bg">
        <div class="bg-inner"></div>
      </div>
    </div>

    <button  class="btn  block-cube block-cube-hover" type="button" id="login">
      <div class="bg-top">
        <div class="bg-inner"></div>
      </div>
      <div class="bg-right">
        <div class="bg-inner"></div>
      </div>
      <div class="bg">
        <div class="bg-inner butonStyle"></div>
      </div>
      <div class="text">Log In</div>
    </button>

    <span id="loginErrors">
        
    </span>

    
  </form>
  <script
        src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous">
    </script>
    <script src="assets/js/main.js" type="text/javaScript"></script>
</body>
</html>

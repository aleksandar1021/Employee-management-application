<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Form</title>
  <link rel="stylesheet" href="assets/css/loginStyle.css" />
</head>
<body>

  <form class="form" autocomplete="off" id="formRegister">
    <div class="control">  
      <h1>Register</h1>
    </div>

    <div class="control block-cube block-input">
      <input name="firstname" type="text" placeholder="Firstname" id="firstname"/>
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
      <input name="lastname" type="text" placeholder="Lastname" id="lastname"/>
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
      <input name="email" type="email" placeholder="Email" id="email"/>
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
      <input name="password" type="password" placeholder="Password" id="password"/>
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

    <button class="btn block-cube block-cube-hover" type="button" id="register">
      <div class="bg-top">
        <div class="bg-inner"></div>
      </div>
      <div class="bg-right">
        <div class="bg-inner"></div>
      </div>
      <div class="bg">
        <div class="bg-inner"></div>
      </div>
      <div class="text">Register</div>
    </button>

    <span id="loginErrors">
        
    </span>

    <p>You already have account? <a class="textAcc" href="?page=login">Login now</a></p>


    
  </form>
  <script
        src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous">
    </script>
    <script src="assets/js/main.js" type="text/javaScript"></script>
</body>
</html>

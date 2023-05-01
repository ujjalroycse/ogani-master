
<?php 
require_once('config.php');
session_start();
// $id = $_REQUEST['id'];

if(isset($_POST['login_form'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){
        $error = "Username is Required!";
    }
    elseif(empty($password)){
        $error = "Password id Required!";
    }
    else{
        $password = SHA1($password);

        $login = $connection->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $login->execute(array($username,$password));
        $loginCount = $login->rowCount();

        if($loginCount == 1){
            $userData = $login->fetch(PDO::FETCH_ASSOC);
            if($userData['email_status'] == 1){
                $_SESSION['user'] = $userData;
                header('location:index.php');
            }
            else{
                header('location:varification.php');
            }

        }
        else{
            $error = "Username Or Password is wrong!";
        }
    }
}

if(isset($_SESSION['user'])){
    header('location:index.php');
}

?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href=admin./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/libs/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    .footer-link-style .footer-link:hover,
    .footer-link-style .footer-link:focus{
        color: blue;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                <a href="./index.php"><img style="width: 100px;" src="img/logo.png" alt=""></a>
                <span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
                <?php if(isset($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <?php if(isset($success)) : ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="username" name="username" type="text" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password" name="password" type="password" placeholder="Password">
                    </div>

                    <button type="submit" name="login_form" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <div class="card-footer footer-link-style bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="registration.php" class="footer-link">Create An Account</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="admin/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="admin/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>
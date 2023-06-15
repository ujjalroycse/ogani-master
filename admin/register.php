
<?php 
require_once('../config.php');
session_start();
// $id = $_REQUEST['id'];

if(isset($_POST['admin_register'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date_of_birth = $_POST['date_birth'];
    $photo = $_POST['photo'];

    $sameUsername = InputCount('admins','username',$username);
    $sameUseremail = InputCount('admins','email',$email);

    if(empty($name)){
        $error = "Name is Required!";
    }
    elseif(empty($username)){
        $error = "Username is Required!";
    }
    elseif($sameUsername != 0){
        $error = "Username already used!";
    }
    elseif(empty($email)){
        $error = "Email is Required!";
    }
    elseif($sameUseremail != 0){
        $error = "Email already used!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Email is Wrong!";
    }
    elseif(empty($password)){
        $error = "Password id Required!";
    }
    else{
        $created_at = date("Y-m-d H:i:s");
        $email_code = rand(11111,99999);
        $password = SHA1($password);
        $username = strtolower($username);

        $statement = $connection->prepare("INSERT INTO admins(name,username,email,password,email_code,photo,status,date_of_birth,created_at) VALUES(?,?,?,?,?,?,?,?,?) ");
        $result = $statement->execute(array($name,$username,$email,$password,$email_code,$photo,"Pending",$date_of_birth,$created_at));
        if($result == true){
            $success = "Your Registration Successfully!";

            //Send email verification
            $message = "Your verification code is: ".$email_code;
            mail($email,"Email Verification",$message);

            $_SESSION['user_email'] = $userData['email'];

            header('location:verification.php');

        }
        else{
            $error = "Registration Failed!";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#"><img src="../img/logo.png" alt="Ogani Master"></a>
                    </div>
                    <h2 class="text-center text-success">Registration</h2>
                    <hr>
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
                    <div class="login-form">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input class="au-input au-input--full" type="text" id="name" name="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="username">Username *</label>
                                <input class="au-input au-input--full" type="text" id="username" name="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input class="au-input au-input--full" type="email" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input class="au-input au-input--full" type="password" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo *</label>
                                <input class="au-input au-input--full" type="file" id="photo" name="photo">
                            </div>
                            <div class="form-group">
                                <label for="date_birth">Date Of Birth *</label>
                                <input class="au-input au-input--full" type="date" id="date_birth" name="date_birth">
                            </div>
                            <div class="login-checkbox">
                                <label>
                                    <input type="checkbox" name="aggree">Agree the terms and policy
                                </label>
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" name="admin_register" type="submit">Registration</button>
                        </form>
                        <div class="register-link">
                            <p>
                                Already have account?
                                <a href="logout.php">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
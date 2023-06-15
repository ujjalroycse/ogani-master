<?php 
require_once('config.php');
session_start();
// $id = $_REQUEST['id'];

if(isset($_POST['registration'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];

    $sameUsername = InputCount('users','username',$username);
    $sameUseremail = InputCount('users','email',$email);

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

        $statement = $connection->prepare("INSERT INTO users(name,username,email,password,email_code,date_of_birth,address,status,created_at) VALUES(?,?,?,?,?,?,?,?,?) ");
        $result = $statement->execute(array($name,$username,$email,$password,$email_code,$date_of_birth,$address,"Pending",$created_at));
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
    <title>Registration</title>

    <!-- Fontfaces CSS-->
    <link href="admin/css/font-face.css" rel="stylesheet" media="all">
    <link href="admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="admin/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="admin/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#"><img src="img/logo.png" alt="Ogani Master"></a>
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
                                <label style="font-weight: 600;color:black;" for="name">Name :</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="name">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600;color:black;" for="username">User Name :</label>
                                <input class="form-control" type="text" id="username" name="username" placeholder="username">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600;color:black;" for="email">Email :</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="e-mail">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600;color:black;" for="password">Password :</label>
                                <input class="form-control" id="password" name="password" type="password" placeholder="password">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600;color:black;" for="birth">Date Of Birth :</label>
                                <input class="form-control" id="birth" name="date_of_birth" type="date">
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600;color:black;" for="address">Address :</label>
                                <textarea name="address" id="address" class="form-control" ></textarea>
                            </div>
                            <div class="login-checkbox">
                                <label>
                                    <input type="checkbox" name="aggree">Agree the terms and policy
                                </label>
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" name="registration" type="submit">Registration</button>
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
    <script src="admin/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="admin/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="admin/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="admin/vendor/slick/slick.min.js">
    </script>
    <script src="admin/vendor/wow/wow.min.js"></script>
    <script src="admin/vendor/animsition/animsition.min.js"></script>
    <script src="admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="admin/vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="admin/vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="admin/vendor/circle-progress/circle-progress.min.js"></script>
    <script src="admin/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="admin/vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="admin/vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="admin/js/main.js"></script>

</body>

</html>
<!-- end document-->
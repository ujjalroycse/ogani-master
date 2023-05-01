<?php 
require_once('config.php');
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
        }
        else{
            $error = "Registration Failed!";
        }
    }
}

?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="admin/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="admin/assets/libs/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->

<body>
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-1">Registrations Form</h3>
                    <p>Please enter your user information.</p>
                </div>
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

                    <form action="" method="POST" >
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
                        <div class="form-group pt-2 text-center">
                            <button class="btn btn-primary" name="registration" style="border-radius: 5px;" type="submit">Register My Account</button>
                        </div>

                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">By creating an account, you agree the <a href="#">terms and conditions</a></span>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white">
                    <p>Already member? <a href="login.php" class="text-secondary">Login Here.</a></p>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

 
</html>
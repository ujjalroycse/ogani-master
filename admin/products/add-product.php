<?php 
require_once('../../config.php');
get_header();

$user_id = $_SESSION['user']['id'];

if(isset($_POST['product_sub'])){
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $photo = $_FILES['photo'];
    $expire_date = $_POST['expire_date'];

    $target_directory = "product-photo/";
    $target_file = $target_directory . basename($_FILES["photo"]["name"]);
    $photoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(empty($product_name)){
        $error = "Product name is required!";
    }
    elseif(empty($category)){
        $error = "Category is required!";
    }
    elseif(empty($photo['name'])){
        $error = "Photo is required!";
    }
    elseif(empty($expire_date)){
        $error = "Expire Date is required!";
    }
    elseif($photoFileType != 'jpg' && $photoFileType != 'png' && $photoFileType != 'JPG' && $photoFileType != 'jpeg'){
        $error = "Photo extension is wrong. please used jpg or png or JPG or jpeg extension!";
    }
    else{
        $new_photo_name = $user_id." - ".rand(1111,9999)."-".time()."." .$photoFileType;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_directory.$new_photo_name);

        $date = date('Y-m-d H:i:s');
        $stm = $connection->prepare("INSERT INTO products(user_id,product_name,category,description,photo,stock,expire_date,created_at) VALUES(?,?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$product_name,$category,$description,$new_photo_name,'null',$expire_date,$date));

        $success = "Product create Successfully.";
    }

}

?>


    <div class="container mt-3">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3>Create New Products</h3>
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name">Product Name :</label>
                                <input class="form-control" type="text" id="product_name" name="product_name" placeholder="Product name">
                            </div>
                            <div class="form-group pt-2">
                                <label for="category">Category :</label>
                                <select name="category" id="category" class="form-control">
                                    <option selected value="1">Select option</option>
                                    <?php 
                                    $categories = getTableData('categories');
                                    foreach($categories as $category) :
                                    ?>
                                    <option value="<?php echo $category['id'] ?>"><?php echo $category['category_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group pt-2">
                                <label for="description">Description :</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group pt-2">
                                <label for="photo">Photo :</label>
                                <input class="form-control " type="file" id="photo" name="photo">
                            </div>
                            <div class="form-group pt-2">
                                <label for="expire_date">Expire Date :</label>
                                <input class="form-control " type="date" id="expire_date" name="expire_date">
                            </div>
                            <div class="form-group pt-2 text-center">
                                <button class="btn btn-primary" style="border-radius: 5px;" type="submit" name="product_sub">Create Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    
<?php 

get_footer();

?>

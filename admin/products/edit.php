<?php 
require_once('../../config.php');
get_header();

$id = $_REQUEST['id'];
$user_id = $_SESSION['user']['id'];

if(isset($_POST['product_sub'])){
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $photo = $_FILES['photo'];

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
    elseif($photoFileType != 'jpg' && $photoFileType != 'png' && $photoFileType != 'JPG' && $photoFileType != 'jpeg'){
        $error = "Photo extension is wrong. please used jpg or png or JPG or jpeg extension!";
    }
    else{
        $new_photo_name = $user_id." - ".rand(1111,9999)."-".time()."." .$photoFileType;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_directory.$new_photo_name);

        $stm = $connection->prepare("UPDATE products SET product_name=?,category=?,description=?,photo=? WHERE user_id=? AND id=?");
        $stm->execute(array($product_name,$category,$description,$new_photo_name,$user_id,$id));

        $success = "Product Update Successfully.";
    }

}

?>


    <div class="container mt-3">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3>Edit Category</h3>
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
                            <?php 
                            $productData = getSingleData('products',$id)
                            ?>
                            <div class="form-group">
                                <label for="product_name">Product Name :</label>
                                <input class="form-control" type="text" id="product_name" name="product_name" value="<?php echo $productData['product_name'] ?>">
                            </div>
                            <div class="form-group pt-2">
                                <label for="category">Category :</label>
                                <select name="category" id="category" class="form-control">
                                    <option selected value="1">Select option</option>
                                    <?php 
                                    $categories = getTableData('categories');
                                    foreach($categories as $category) :
                                    ?>
                                    <option value="<?php echo $category['id'] ?>"
                                    <?php 
                                        if($category['id'] == $productData['category']){
                                            echo "selected";
                                        }
                                    ?>
                                    ><?php echo $category['category_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group pt-2">
                                <label for="description">Description :</label>
                                <textarea name="description" id="description" class="form-control"><?php echo $productData['description'] ?></textarea>
                            </div>
                            <div class="form-group pt-2">
                                <label for="photo">Photo :</label>
                                <input class="form-control " type="file" id="photo" name="photo" <?php echo $productData['photo'] ?>><br>
                                <div class="images">
                                    <img style="width:150px; height:auto" src="product-photo/<?php echo $productData['photo']; ?>">
                                </div><br>
                            </div>
                            <!-- <div class="form-group pt-2">
                                <label for="stock">Stock :</label>
                                <input class="form-control " type="text" id="stock" name="stock">
                            </div> -->
                            <div class="form-group pt-2 text-center">
                                <button class="btn btn-primary" style="border-radius: 5px;" type="submit" name="product_sub">Update Product</button>
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

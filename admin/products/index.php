<?php 
require_once('../../config.php');
get_header();

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

        $date = date('Y-m-d H:i:s');
        $stm = $connection->prepare("INSERT INTO products(user_id,product_name,category,description,photo,stock,created_at) VALUES(?,?,?,?,?,?,?)");
        $stm->execute(array($user_id,$product_name,$category,$description,$new_photo_name,'null',$date));

        $success = "Product create Successfully.";
    }

}

?>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <!-- DATA TABLE-->
                <h3 class="text-primary mb-3">All Categories</h3>
                <?php if(isset($_REQUEST['success'])) : ?>
                    <div class="alert alert-success">
                        <?php echo $_REQUEST['success']; ?>
                    </div>
                <?php endif; ?>
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Photo</th>
                                <th>Expire Date</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $products = getTableData('products');
                            $i = 1;
                            foreach($products as $product) :
                            ?>
                            <tr>
                                <td><?php echo $i;$i++ ?></td>
                                <td><?php echo $product['product_name'] ?></td>
                                <td><?php echo getColumnDetails('categories','category_name',$product['category']); ?></td>
                                <td><?php echo $product['description'] ?></td>
                                <td><img src="product-photo/<?php echo $product['photo'] ?>" style="width:100px;" alt="photo"></td>
                                <td><?php echo date('d-m-Y',strtotime($product['expire_date'])) ?></td>
                                <td><?php echo date('d-m-Y',strtotime($product['created_at'])) ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $product['id']; ?>" class="badge badge-primary">Edit</a>
                                    <a onclick="return confirm('Are You Sure?')" href="delete.php?id=<?php echo $product['id']; ?>" class="badge badge-danger">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->
            </div>
        </div>
    </div>



    
<?php 

get_footer();

?>


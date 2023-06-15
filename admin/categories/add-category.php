<?php 
require_once('../../config.php');
get_header();

$user_id = $_SESSION['user']['id'];

if(isset($_POST['category_sub'])){
    $category_name = $_POST['category_name'];
    $category_slug = $_POST['category_slug'];
    $charatcers = "/^[a-z-0-9]+$/";

    $cateSlug = InputCount('categories','category_slug',$category_slug);

    if(empty($category_name)){
        $error = "Category name is required!";
    }
    elseif(empty($category_slug)){
        $error = "Category slug is required!";
    }
    elseif($cateSlug != 0){
        $error = "Categpry slug already exits!";
    }
    elseif(!preg_match($charatcers, $category_slug)){
        $error = "Use only small letter!";
    }
    else{
        $date = date('Y-m-d H:i:s');
        $stm = $connection->prepare("INSERT INTO categories(user_id,category_name,category_slug,created_at) VALUES(?,?,?,?)");
        $stm->execute(array($user_id,$category_name,$category_slug,$date));

        $success = "Category create Successfully.";
    }

}

?>


    <div class="container mt-3">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3>Create New Category</h3>
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
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="category_name">Category Name :</label>
                                <input class="form-control" type="text" id="category_name" name="category_name" placeholder="Category name">
                            </div>
                            <div class="form-group pt-2">
                                <label for="category_slug">Category Slug :</label>
                                <input class="form-control " type="text" id="category_slug" name="category_slug" placeholder="Category slug">
                            </div>
                            <div class="form-group pt-2 text-center">
                                <button class="btn btn-primary" style="border-radius: 5px;" type="submit" name="category_sub">Create Category</button>
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

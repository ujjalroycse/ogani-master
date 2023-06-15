<?php 
require_once('../../config.php');
get_header();

$id=$_REQUEST['id'];
$user_id = $_SESSION['user']['id'];

if(isset($_POST['update'])){
    $category_name = $_POST['category_name'];
    $category_slug = $_POST['category_slug'];
    $charatcers = "/^[a-z-0-9]+$/";

    $cateSlug = InputCount('categories','category_slug',$category_slug);

    $stm = $connection->prepare("SELECT category_slug FROM categories WHERE category_slug=? AND id=? ");
    $stm->execute(array($category_slug,$id));
    $comonSlug = $stm->rowCount();

    if(empty($category_name)){
        $error = "Category name is required!";
    }
    elseif(empty($category_slug)){
        $error = "Category slug is required!";
    }
    elseif($cateSlug != 0 AND $comonSlug != 1){
        $error = "Categpry slug already exits!";
    }
    elseif(!preg_match($charatcers, $category_slug)){
        $error = "Use only small letter!";
    }
    else{
        $date = date('Y-m-d H:i:s');
        $stm = $connection->prepare("UPDATE categories SET category_name=?,category_slug=? WHERE user_id=? AND id=?");
        $stm->execute(array($category_name,$category_slug,$user_id,$id));

        $success = "Category Update Successfully.";
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
                        <form action="" method="POST">
                            <?php 
                            $categoryData = getSingleData('categories',$id)
                            ?>
                            <div class="form-group">
                                <label for="category_name">Category Name :</label>
                                <input class="form-control" type="text" id="category_name" name="category_name" value="<?php echo $categoryData['category_name'] ?>">
                            </div>
                            <div class="form-group pt-2">
                                <label for="category_slug">Category Slug :</label>
                                <input class="form-control " type="text" id="category_slug" name="category_slug" value="<?php echo $categoryData['category_slug'] ?>">
                            </div>
                            <div class="form-group pt-2 text-center">
                                <button class="btn btn-primary" style="border-radius: 5px;" type="submit" name="update">Update Category</button>
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

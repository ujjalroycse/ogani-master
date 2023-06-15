<?php 
require_once('../../config.php');
get_header();

$user_id = $_SESSION['user']['id'];

if(isset($_POST['category_sub'])){
    $category_name = $_POST['category_name'];
    $category_slug = $_POST['category_slug'];

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
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $categories = getTableData('categories');
                            $i = 1;
                            foreach($categories as $category) :
                            ?>
                            <tr>
                                <td><?php echo $i;$i++ ?></td>
                                <td><?php echo $category['category_name'] ?></td>
                                <td><?php echo $category['category_slug'] ?></td>
                                <td><?php echo date('d-m-Y',strtotime($category['created_at'])) ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $category['id']; ?>" class="badge badge-primary">Edit</a>
                                    <a onclick="retuen confirm('Are You Sure?')" href="delete.php?id=<?php echo $category['id']; ?>" class="badge badge-danger">Delete</a>
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


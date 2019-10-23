<?php include('includes/header.php');?>
<?php 
if(!isset($_SESSION['admin'])){
    header("location:login.php");
}
$errors = [];
$message = "";
$id = mysqli_escape_string($con,$_GET['id']);
//get post
$query = "SELECT * FROM articles WHERE id='$id'";
if(mysqli_query($con,$query)){
    $result = mysqli_query($con,$query);
    $post = $result->fetch_assoc();
}
//get post category
function getCat($con,$post_id){
    $getCatQuery = "SELECT * FROM categories WHERE id='$post_id'";
    mysqli_query($con,$getCatQuery);
    $result = mysqli_query($con,$getCatQuery);
    return $category = $result->fetch_assoc();
}
$category = getCat($con,$post['category_id']);
//form validation
if(isset($_POST['submit'])){
    if(empty($_POST['title'])){
        $errors = "Veuillez remplir le champ titre";
    }else if(empty($_POST['body'])){
        $errors = "Veuillez remplir le champ déscription";
    }else{
        $title = mysqli_escape_string($con,$_POST['title']);
        $body = mysqli_escape_string($con,$_POST['body']);
        $categorie = mysqli_escape_string($con,empty($_POST['categorie']) ? $category['id'] : $_POST['categorie']);
        $image = mysqli_escape_string($con,empty($_FILES['image']["name"]) ? $post['image'] :$_FILES['image']["name"]);
        //upload image to images
        $directory = "images/";
        $file = $directory.basename($_FILES["image"]["name"]);
        $author = "belasri imad";    
        $created = date('Y-m-d H:s:m');
        $query = "UPDATE  articles SET title='$title',body='$body',image='$image',author='$author',category_id='$categorie',created = '$created' WHERE id='$id'";
        if(mysqli_query($con,$query)){
            move_uploaded_file($_FILES["image"]["tmp_name"],$file);
            $message = '<div class="alert alert-success">
                       Article modifié avec succés 
                  </div>';
        }else{
             echo '<div class="alert alert-danger">Une erreur est survenue'.mysqli_error($con).'</div>';
        }
    }
}
?>
<div class="container-fluid">
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-3 col-md-2 sidebar">
           <?php include('includes/sidebar.php');?>
        </div>
            <div class="col-sm-6 col-md-6 col-md-offset-1 col-sm-offset-1 main">
            <h2 class="sub-header text-primary">Modifier un article</h2>
            <hr>
                <?php
                    if(!empty($errors)){
                        echo '<div class="alert alert-danger">
                                '.$errors.'
                            </div><br>';
                    }else{
                        echo $message;
                    }
                ?>
                <form action="editPost.php?id=<?php echo $post['id'];?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <p><span class="text-danger">Catégorie actuelle :<?php echo $category['name'];?></span></p>
                        <label for="categorie">Catégorie:</label>
                        <select name="categorie" id="categorie" class="form-control">
                            <option  selected="" disabled>Veuillez choisir une catégorie</option>
                            <?php
                                $query = "SELECT * FROM categories";
                                if(mysqli_query($con,$query)):
                                    $result = mysqli_query($con,$query);
                                    while($row = $result->fetch_assoc()):
                            ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php
                                endwhile;
                                endif;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Titre:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Entrer le titre" value="<?php echo $post['title'];?>">
                    </div>
                    <div class="form-group">
                        <label for="body">Déscription:</label>
                        <textarea  class="form-control" rows="5" cols="30" name="body" id="body" placeholder="Entrer la déscription"><?php echo $post['body'];?></textarea>
                    </div>
                    <p><span class="text-danger">Image actuelle :</p>
                    <p><img src="images/<?php echo $post['image'];?>" alt="" width="50" height="50"></p>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" name="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>
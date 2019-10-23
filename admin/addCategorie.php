<?php include('includes/header.php');?>
<?php 
if(!isset($_SESSION['admin'])){
    header("location:login.php");
}
$errors = [];
$message = "";
if(isset($_POST['submit'])){
    if(empty($_POST['name'])){
        $errors = "Veuillez remplir le champ titre";
    }else{
        $name = mysqli_escape_string($con,$_POST['name']);
        $added_by = $_SESSION['admin_name'];
        $query = "INSERT INTO categories (name,added_by) values('$name','$added_by')";
        if(mysqli_query($con,$query)){
            $message = '<div class="alert alert-success">
                       Catégorie ajoutée avec succés 
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
            <h2 class="sub-header text-primary">Ajouter une categorie</h2>
            <hr>
                <?php
                    if(!empty($errors)){
                        echo '<div class="alert alert-danger">
                                '.$errors.'
                            </div>';
                    }else{
                        echo $message;
                    }
                ?>
                <form action="addCategorie.php" method="post">
                    <div class="form-group">
                        <label for="name">Titre:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Entrer le titre">
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
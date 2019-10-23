<?php 
include('includes/header.php');
$errors =[];
$message = "";
if(isset($_POST['submit'])){
    $name = mysqli_escape_string($con,$_POST['name']);
    $email = mysqli_escape_string($con,$_POST['email']);
    $message = mysqli_escape_string($con,$_POST['message']);
    $created = date('Y-m-d H:s:m');
    if(empty($_POST['name'])){
        $errors = "Veuillez remplir le champ nom & prénom";
    }else if(empty($_POST['email'])){
        $errors = "Veuillez remplir le champ email";
    }else if(empty($_POST['message'])){
        $errors = "Veuillez remplir le champ message";
    }else{
        $query = "INSERT INTO contacts (name,email,message,created) values('$name','$email','$message','$created')";
        if(mysqli_query($con,$query)){
             $message = '<div class="alert alert-success">
                    Message envoyé avec succés 
                </div>';
        }else{
            echo '<div class="alert alert-danger">Une erreur est survenue'.mysqli_error($con).'</div>';
        }
    }
}
?>
<div class="container">
    <div class="row" style="margin-top:50px">
        <div class="col-md-6 col-md-offset-3">
            <?php 
                if(!empty($errors)){
                    echo '<div class="alert alert-danger">
                            '.$errors.'
                        </div><br>';
                }else{
                    echo $message;
                }
            ?>
            <form  method="post" action="contact.php">
                <div class="form-group">
                    <label for="name">Nom & Prénom:</label>
                    <input type="hidden" id="post_id" value="<?php echo $id;?>">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Entrer votre nom" value="<?php echo isset($_SESSION['email']) ? $_SESSION['name'] : "";?>">
                </div>
                <div class="form-group">
                    <label for="name">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrer votre email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : "";?>">
                </div>
                <div class="form-group">
                    <label for="body">Message:</label>
                    <textarea  class="form-control" rows="5" cols="30" name="message" id="message" placeholder="Entrer votre message"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" name="submit">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>
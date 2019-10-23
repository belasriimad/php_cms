<?php include('includes/header.php');?>
<?php
if(!isset($_SESSION['admin'])){
    header("location:login.php");
}
$query = "SELECT * FROM admins";
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <h3 class="text-info">Ajouter un admin</h3>
        <hr>
            <div id="result"></div>
            <form  method="post" id="addAdmin">
                <div class="form-group">
                    <label for="name">Nom & Prénom:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Entrer votre nom">
                </div>
                <div class="form-group">
                    <label for="name">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrer votre email">
                </div>
                <div class="form-group">
                    <label for="name">Mot de passe:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrer votre mot de passe">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" name="submit">Valider</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-3 col-md-2 sidebar">
           <?php include('includes/sidebar.php');?>
        </div>
        <div class="col-sm-6 col-md-8 col-md-offset-1 col-sm-offset-1 main">
          <h2 class="sub-header text-primary">Admins</h2>
          <hr>
          <?php
              if(isset($_GET['deleted'])){
                  echo '<div class="alert alert-success">Admin supprimé</div><br>';
              }
          ?>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nom & Prénom</th>
                  <th>Email</th>
                  <th>Ajouté par</th>
                  <th>Ajouté le</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if(mysqli_query($con,$query)):
                    $result = mysqli_query($con,$query);
                    while($row = $result->fetch_assoc()):
              ?>
                <tr>
                  <td><?php echo $row['id'];?></td>
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo $row['added_by'];?></td>
                  <td><?php echo $row['created'];?></td>
                  <td>
                     <a href="deleteAdmin.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-xs" style="margin:2px;"><i class="glyphicon glyphicon-trash"></i></a>
                  </td>
                </tr>
              <?php
                  endwhile;
                  endif;
              ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>
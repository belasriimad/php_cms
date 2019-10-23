<?php 
include('includes/header.php');
function getCat($con,$id){
    $getCatQuery = "SELECT * FROM categories WHERE id='$id'";
    mysqli_query($con,$getCatQuery);
    $result = mysqli_query($con,$getCatQuery);
    return $category = $result->fetch_assoc();
}
?>
<div class="container">
    <div class="row" style="margin-top:50px">
        <div class="col-md-8">
            <div class="panel panel-default" style="padding:20px">
                <?php
                    $id = mysqli_escape_string($con,$_GET['id']);
                    $query = "SELECT * FROM articles WHERE id='$id'";
                    if(mysqli_query($con,$query)):
                        $result = mysqli_query($con,$query);
                        $row = $result->fetch_assoc();
                ?>
                <?php
                   $category = getCat($con,$row['category_id']);
                ?>
                <div class="media">
                    <div class="image">
                        <img src="admin/images/<?php echo $row['image'];?>" class="media-object" alt="" height="200" width="400">
                    </div>
                    <div class="media-body" style="padding:10px">
                        <h3 class="media-heading text-primary"><?php echo $row['title'];?></h3>
                        <small class="text-danger"><i class="glyphicon glyphicon-time"></i> <?php echo $row['created'];?></small>
                        <small class="text-success"><i class="glyphicon glyphicon-tags"></i> <?php echo $category['name'];?></small>
                        <p class=""><?php echo $row['body'];?></p>
                    </div>
                </div>    
                <?php
                    endif;
                ?>
                <hr>
                <h4 class="text-default">Commentaires</h4>
                <hr>
                <?php
                    $id = $row['id'];
                    $query = "SELECT * FROM comments WHERE post_id = '$id' AND status = 1 order by created DESC";
                    if(mysqli_query($con,$query)):
                        $result = mysqli_query($con,$query);
                        while($row = $result->fetch_assoc()):
                ?>
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                           <img class="media-object" src="http://lorempixel.com/50/50/" alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading text-info"><?php echo $row['name'];?></h4>
                        <p><?php echo $row['comment'];?> <small class="text-danger"><?php echo $row['created'];?></small></p>
                    </div>
                </div>
                <?php
                        endwhile;
                    endif;
                ?>
                <hr>
                <div id="result"></div>
                <form  method="post" id="addComment">
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
                        <label for="body">Commentaire:</label>
                        <textarea  class="form-control" rows="5" cols="30" name="comment" id="comment" placeholder="Entrer votre commentaire"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" name="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
           <ul class="list-group">
               <li class="list-group-item li-nav">
                    Catégories
               </li>
               <?php
                $query = "SELECT * FROM categories";
                if(mysqli_query($con,$query)):
                    $result = mysqli_query($con,$query);
                    while($row = $result->fetch_assoc()):
                ?>
               <li class="list-group-item">
                    <a href="categoryPosts.php?id=<?php echo $row['id'];?>"><?php echo $row['name'];?></a>                  
               </li>
               <?php
                  endwhile;
                  endif;
              ?>
           </ul>
        </div>
        <div class="col-md-4">
           <ul class="list-group">
               <li class="list-group-item li-nav">
                    Dérniers Articles
               </li>
               <li class="list-group-item">
                    <?php
                        $query = "SELECT * FROM articles order by created DESC LIMIT 5";
                        if(mysqli_query($con,$query)):
                            $result = mysqli_query($con,$query);
                            while($row = $result->fetch_assoc()):
                    ?>
                    <div class="media">
                        <div class="image media-left">
                            <img src="admin/images/<?php echo $row['image'];?>" class="media-object" alt="" height="60" width="60">
                        </div>
                        <div class="media-body" style="padding:5px">
                            <h4 class="media-heading text-primary"><a href="viewPost.php?id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a></h4>
                            <p class=""><?php echo substr($row['body'],0,20).'...';?></p>
                        </div>
                    </div>    
                    <hr>
                    <?php
                        endwhile;
                        endif;
                    ?>
               </li>
           </ul>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>
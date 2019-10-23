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
                    $query = "SELECT * FROM articles";
                    if(mysqli_query($con,$query)):
                        $result = mysqli_query($con,$query);
                        while($row = $result->fetch_assoc()):
                ?>
                <?php
                   $category = getCat($con,$row['category_id']);
                ?>
                <div class="media post">
                    <div class="image media-left">
                        <img src="admin/images/<?php echo $row['image'];?>" class="media-object" alt="" height="200" width="200">
                    </div>
                    <div class="media-body" style="padding:10px">
                        <h3 class="media-heading text-primary"><a href="viewPost.php?id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a></h3>
                        <small class="text-danger"><i class="glyphicon glyphicon-time"></i> <?php echo $row['created'];?></small>
                        <small class="text-success"><i class="glyphicon glyphicon-tags"></i> <?php echo $category['name'];?></small>
                        <p class=""><?php echo substr($row['body'],0,150).'...';?></p>
                    </div>
                </div>    
                <hr>
                <?php
                    endwhile;
                    endif;
                ?>
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
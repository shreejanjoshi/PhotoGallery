<?php include("includes/header.php"); ?>

<?php
    $photos = Photo::find_all();

    //page setting this by assigning get request
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    //4 item per and then newt page
    $items_per_page = 4;

    $items_total_count = Photo::count_all();
?>
<div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-12">

        <div class="thumbnails row">

            <?php  foreach ($photos as $photo):  ?>
                <div class="col-xs-6 col-md-3">
                    <!-- link to go to that photo page -->
                    <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                        <img class="home_page_photo img-responsive " src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                        <h4 class="text-center"><?php echo $photo->title; ?></h4>
                    </a>

                </div>
            <?php endforeach; ?>

        </div>
    </div>



            <!-- Blog Sidebar Widgets Column -->
            <!--  <div class="col-md-4"> -->

            
                 <?php // include("includes/sidebar.php"); ?>



             </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>

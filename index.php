<?php include("includes/header.php"); ?>

<?php
    //page setting this by assigning get request
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    //4 item per and then newt page
    $items_per_page = 4;

    $items_total_count = Photo::count_all();


//we dont want to find find all because it will all photo in index page so I am gonna make custom sql for that
//we want to limit now many items we want on the page and we want to oofset
//$photos = Photo::find_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos ";
$sql .= "LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";

$photos = Photo::find_by_query($sql);

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

        <div class="row">
            <ul class="pager">

                <?php
                //next page or pervious page
                    if($paginate->page_total() > 1) {
                        if ($paginate->has_next()) {
                            echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                        }
                        //show the number which page we at ---- loop
                        for($i=1; $i <= $paginate->page_total(); $i++) {
                            //in place $paginate->current_page() this we can also put $page ... we have up
                            if($i == $paginate->current_page){
                                echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                            }else{
                                echo "<li><a href='index.php?page={$i}'>{$i}</li>";
                            }
                        }

                        if ($paginate->has_previous()) {
                            echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                        }
                    }
                ?>

            </ul>
        </div>
    </div>

            <!-- Blog Sidebar Widgets Column -->
            <!--  <div class="col-md-4"> -->

            
                 <?php // include("includes/sidebar.php"); ?>



             </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>

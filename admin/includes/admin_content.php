<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php
                //$user = new User();
                //$user->username ="555";
                //$user->password ="1231321";
                //$user->first_name ="h5465465ello";
                //$user->last_name ="worl856798d";
                //$user->create();

                //$user = User::find_by_id(28);
                //$user->delete();

            //$user = User::find_by_id(14);
            //$user->username = "sdfsdf";
            //$user->save();

            //$user = new User();
            //$user->username ="hi";
            //$user->save();

            $users = User::find_all();
            foreach($users as $user){
                echo $user->username;
            }
            ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>

<!-- /.container-fluid -->

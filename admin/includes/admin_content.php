<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>


            <?php

            //testing user class find all methode
            //$user = new User();
            //$result_set = User::find_all_users();
            //while ($row = mysqli_fetch_array($result_set)){
              //  echo $row['username']. "<br>";
            //}

            //testing user by id
            //id of user here
           // $found_user = User::find_user_by_id(1);
            //got id then to find their info FOUND USER IS THE RECORD
            //$user = User::instantation($found_user);
            //echo $user->password;

            // $users = User::find_all_users();
            //foreach ($users as $user){
            //  echo $user->id . "<br>";
            //}

            $found_user = User::find_user_by_id(1);
            echo $found_user->username;
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

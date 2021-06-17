<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Blank Page
            <small>Subheading</small>
        </h1>

        <?php 
        /*
      

        $user = User::find_user_by_id(1);

        $user->last_name = "TARIK";

        $user->update();

        
        $user = User::find_user_by_id(4);

        $user->username = "bilosto";
        $user->save(); 
*/

$photo = new Photo();

$photo->title = "hehehe";
$photo->size = "23";

$photo->create();

        ?>

        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Admin Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->
<?php include("includes/header.php"); ?>

<?php 
    
    //ako korisnik nije prijavljen, redirect metoda upravlja i vraća na početnu stranicu login
if(!$session->is_signed_in()){

    redirect("login.php");
  }
   ?>


<?php 


$photos = Photo::find_all();



?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
          
        <?php include("includes/top_nav.php"); ?>


        <?php include("includes/side_nav.php"); ?>


          <!-- /.navbar-collapse -->
          </nav>

        <div id="page-wrapper">


        <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                
                <div class="form-group">
                    


                </div>
               

            </div>

            </div>
        </div>
        <!-- /.row -->

        </div>
        <!-- /.container-fluid -->   




        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
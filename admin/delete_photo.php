<?php include("includes/init.php");

//ako korisnik nije prijavljen, redirect metoda upravlja i vraća na početnu stranicu login
if(!$session->is_signed_in()){

  redirect("login.php");
}


 

?>


<?php

//ako je prazan photo id, naredna putanja jeste na photos
if(empty($_GET['id'])){
    
    redirect("../photos.php");

}


$photo = Photo::find_by_id($_GET['id']);

//ako je true photo onda će se obrisati, ako je false putanja će nas vratiti u photos
if($photo){

    $photo->delete_photo();
    redirect("../photos.php");

}else{

    redirect("../photos.php");

}

?>
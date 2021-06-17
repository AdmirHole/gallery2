<?php require_once("includes/header.php"); 
    require_once("includes/functions.php");
?>

<?php 

//ako je korisnik prijavljen redirect šalje na admin stranicu
if($session->is_signed_in()){

    redirect("index.php");
}

if(isset($_POST['submit'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //metoda za provjeru baze podataka korisnika
    $user_found = User::verify_user($username, $password);




    //ako je korisnik pronadjen prijavit ce se na stranicu 
    if($user_found){

        $session->login($user_found);
        redirect("index.php");
    
    }else{
        //ako korisnik nije pronadjen poruka ce se prikazati
        $the_message = "Your password or username is incorrect";


    }


}else{
    
    //ako nemamo nista
    $username = "";
    $password = "";
    $the_message = "";

}


?>

<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php echo $the_message; ?></h4>
	
<form id="login-id" action="" method="post">
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
	
</div>


<div class="form-group">
<input type="submit" name="submit" value="Submit" class="btn btn-primary">

</div>


</form>


</div>
<?php 

//Svaki put kada je neko na našoj web stranici želimo da sesija bude dostupna jer želimo provjeriti jesu li korisnici prijavljeni ili ako su sada prijavljeni, a ako dodajemo pod tim uvjetom želimo nešto učiniti s informacijama 
class Session{

    //svojstva
    private $signed_in = false;
    public $user_id;
    public $message;

    //startali smo sessiu u konstruktoru
    function __construct(){

        session_start();
        $this->check_the_login();
        $this->check_message();

    }

    //metoda namjenjena za poruke
    public function message($msg=""){

        if(!empty($msg)){

            $_SESSION['message'] = $msg;
        
        
        }else{

            return $this->message;

        }

    }

    //metoda namjenjena za provjeru poruke
    private function check_message(){

        //ako postavimo, zgrabit ćemo tu poruku sesije i dodijelit ćemo vrijednost našem svojstvu poruke 
        if(isset($_SESSION['message'])){

            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);

        }else{

            //onda, ako nije postavljeno, želimo zapravo postaviti to svojstvo na prazan niz, tako da nećemo imati grešaka 
            $this->message = "";

        }


    }

    public function is_signed_in(){

        //tako na primjer ako odemo negdje pozvati ovu metodu i naša će stranica vratiti ovo svojstvo 
        return $this->signed_in; 

    }

    //ova ce funkcija prijaviti korisnika 
    public function login($user){

        if($user){

            //dodijeljujemo korisnički ID istovremeno dodijeljujemo i ovome koji koristi korisnički ID sesije za objekat koji se upravo ovdje nalazi
            $this->user_id = $_SESSION['user_id'] = $user->id;

            $this->signed_in = true;
        }

    }


    //metoda za odjavu korisnika
    public function logout(){
        
        //poništavamo sessiu
        unset($_SESSION['user_id']);
        //poništavamo objekat
        unset($this->user_id);

        $this->signed_in = false;

    }



    //provjera za login 
    private function check_the_login(){

        //pa ako je ovo ispravno postavljeno kad korisnik uđe i mi saznamo da jesu, oni stvarno postoje. Zatim nastavimo i primijenimo tu vrijednost sesije na našu imovinu ovdje.
        if(isset($_SESSION['user_id'])){

            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        
        
        }else{

            unset($this->user_id);
            $this->signed_in = false;

        }

    }


}

$session = new Session();











?>
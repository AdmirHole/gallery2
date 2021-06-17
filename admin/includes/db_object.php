<?php 


class Db_object {

    protected static $db_table = "users";

    //uz pomoć ove metode pronalazimo sve korisnike
public static function find_all(){

    //uz pomoć static metode pozivamo find_this_query metodu u kroj koju mozemo pozvati bilo koji query
    return static::find_by_query("SELECT * FROM " .static::$db_table. " ");
        
    
    
    
    }
    
    //uz pomoć ove metode pronalazimo korisnika po id-u
    public static function find_by_id($user_id){
    
       //globalna varijabla za bazu podataka
        global $database;
    
        //query pronalazak korisnika iz tabele, uz pomoć static metode, korisnika po id-u
        $the_result_array = static::find_by_query("SELECT * FROM " .static::$db_table. " WHERE id = $id LIMIT 1");
    
        //ternary operator
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    
    }



    //metodu koju možemo proslijediti u bilo kojem querreyu ako želimo izvršiti bilo koje pravo uz pomoć static metode
public static function find_by_query($sql){
    global $database;

    $result_set = $database->query($sql);

    $the_object_array = array();

    while($row = mysqli_fetch_array($result_set)){

        $the_object_array[] = static::instantation($row);
    }


    return $the_object_array;


}



//ova metoda sluzi za instanciranje parametara, pronalazak korisnika
public static function instantation($the_record){

    //dobivanje imena klase koja poziva statička metoda
    $calling_class = get_called_class();

    //sada će instancirati klasu kodiranja umjesto da instantira klasu Db_object
    $the_object = new $calling_class;

    foreach($the_record as $the_attribute => $value){

        if($the_object->has_the_attribute($the_attribute)){

            $the_object->$the_attribute = $value;



        }
        


    }


    return $the_object;


}

protected function clean_properties(){

    global $database;

    //dodjeljujemo vrijednost ovdje
    $clean_properties = array();

    //izvlačimo ključne vrijednosti iz propertiesa, svojstva.
    foreach ($this->properties() as $key => $value) {

        //a zatim čistimo svoju vrijednost dodjeljumeo vrijednost nizu
        $clean_properties[$key] = $database->escape_string($value);
    }


    return $clean_properties;
}


//ova metoda izvlači sva svojstva iz ove klase 
protected function properties(){

    //return get_object_vars($this);
    $properties = array();

    //želimo izvršiti brzu provjeru da bismo vidjeli da svojstvo postoji i ako postoji želimo potpisati vrijednost 
    foreach (static::$db_table_fields as $db_field) {
        
        if(property_exists($this, $db_field)){

            //pa sada ono što želimo učiniti je da to ovdje potpišemo u taj niz 
            $properties[$db_field] = $this->$db_field;

        }
    }

    return $properties;

}

//stvorili smo metodu za kreiranje, unos tabelu podatak.
public function create(){
    global $database;

    $properties = $this->clean_properties();

    //ivrsili smo apstrakciju implodiramo što znači da svaku vrijednost odvajamo zarezom, a zatim koristimo ključeve,  a zatim pomoću kljuceva izvlačimo ključeve niza, a kljucevi su u liniji koda 6 
    $sql = "INSERT INTO " .static::$db_table. "(" . implode(",", array_keys($properties)) . ")";

    //izvrsili smo apstrakciju, stavljamo sve vrijednosti
    $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";

    //saljemo query
    if($database->query($sql)){

        //izvlačimo id iz posljednjeg query-a
        $this->id = $database->the_insert_id();
        return true;


    }else{

        return false;

    }// Create Method



    

}


//stvorili smo metodu za kreiranje, unos tabelu podatak.
public function createe(){
    global $database;

    $properties = $this->clean_properties();

    //ivrsili smo apstrakciju implodiramo što znači da svaku vrijednost odvajamo zarezom, a zatim koristimo ključeve,  a zatim pomoću kljuceva izvlačimo ključeve niza, a kljucevi su u liniji koda 6 
    $sql = "INSERT INTO " .static::$db_table. "(" . implode(",", array_keys($properties)) . ")";

    //izvrsili smo apstrakciju, stavljamo sve vrijednosti
    $sql .= "VALUES ('". implode("','", array_values($properties)) ."')";

    //saljemo query
    if($database->query($sql)){

        //izvlačimo id iz posljednjeg query-a
        $this->id = $database->the_insert_id();
        return true;


    }else{

        return false;

    }// Create Method



    

}





    //metoda za update-ovanje podataka
    public function update(){   

        global $database;


        $properties = $this->clean_properties();

        $properties_pairs = array();

        //abstrakcija
        foreach ($properties as $key => $value) {

            $properties_pairs[] = "{$key}='{$value}'";

           
        }

        //abstraktovana update metoda 
        $sql = "UPDATE  " .static::$db_table. " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id); 

        $database->query($sql);

        //ternary operator
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;


    }// end of update method





    //metoda za brisanje podataka
    public function delete(){
        global $database;

        $sql = "DELETE FROM  " .static::$db_table. " ";
        $sql .= "WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";


        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;



    }


//stvaranje metode uz pomoć kojeg saznajemo da li je objekt stvarno ili netacno pravo
private function has_the_attribute($the_attribute){

$object_properties = get_object_vars($this);

  return  array_key_exists($the_attribute, $object_properties);

}

//ako je istina update-ovati će se, ako nije kreirati će se 
public function save() {

	return isset($this->id) ? $this->update() : $this->create();

	}


}







?>
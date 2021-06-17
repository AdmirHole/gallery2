<?php


class Photo extends Db_object{

    protected static $db_table = "photos";
    protected static $db_table_fields = array('photo_id', 'title','description', 'filename', 'type', 'size');


    //ključevi/svojstva
    public $photo_id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;
    
    
    
    
    //svojstvo za tmp path
    public $tmp_path;
    //svojstvo za fajl u kojem se uploaduje fotografija
    public $upload_directory = "images";
	public $errors = array();
	public $upload_errors_array = array(


	UPLOAD_ERR_OK           => "There is no error",
	UPLOAD_ERR_INI_SIZE		=> "The uploaded file exceeds the upload_max_filesize directive in php.ini",
	UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
	UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
	UPLOAD_ERR_NO_FILE      => "No file was uploaded.",               
	UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
	UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
	UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."					
												

);

//this is passing $_FILES['uploaded_file'] as an argument
//uz pomoć ove metode postavljamo fajl
public function set_file($file){

    //ako je fajl prazan ili ako nije fajl ili ako nije niz fajl, prikazat će se error poruka
    if(empty($file) || !$file || !is_array($file)){

        //Ali ako ima pogrešku, mi tu pogrešku uzimamo i spremamo u svoj niz 
        $this->errors[] = "There was no file uploaded here";
        return false;


        //na primjer, ako strelica nije jednaka 0 i 0 znači da strelica uopće nema, u redu, pa ako nema pogrešaka, uvijek će se proći.
    }elseif($file['error'] !=0){

        //Ali ako ima pogrešku, mi tu pogrešku uzimamo i spremamo u svoj niz 
        $this->errors[] = $this->upload_errors_array[$file['error']];
        return false;
    
    }else{

    //specifični ključ oko super globalnog imena datoteke svojstva objekta 
    $this->filename =  basename($file['name']);
    $this->tmp_path = $file['tmp_name'];
    $this->type     = $file['type'];
    $this->size     = $file['size'];

    }
    


}

public function picture_path(){

    return $this->upload_directory.DS.$this->filename;

}


//uz pomoć ove metode sačuvamo fajl u bazu podataka
public function save(){

    if($this->id){

        $this->update();

    }else{

        if(!empty($this->errors)){

            return false;
        
        //ako je prazan filename ili prazan path prikazat će se error poruka
        }if(empty($this->filename) || empty($this->tmp_path)){

            $this->errors[] = "The file was not available";

            return false;
        }

        //Upravo sam napravio ovu varijablu ovdje - $target_path
        //SITE_ROOT konstanta koja ima čitav put do web mjesta na mom računalu 
        //. DS . separator
        //admin - spajamo folder
        //upload_directory lokacija za fajlove
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

        //ako imamo isti path, fajl prikazat će se error greška
        if(file_exists($target_path)){

            $this->errors[] = "The file {$this->filename} alredy exists";

            return false;
        }   

        

        //pa ćemo reći, premjestit ćemo datoteku, pokušat ćemo premjestiti datoteku 
        //move_uploaded_file ova funckija uzima temporary path i destinaciju fajla
        if(move_uploaded_file($this->tmp_path, $target_path)){

            //ako je ovo kreirano 
            if($this->create()){

                //tada će se desiti unsetting
                unset($this->tmp_path);

                    return true;
                }



            }else{
                //error poruka
                $this->errors[] = "The folder probably does not have permission";

                return false;

                
            }


            $this->create();

        }


    }


    //metoda namjenjena za brisanje fotografije    
    public function delete_photo(){

        //ako je istina, fotografija će se obrisati
        if($this->delete()){

            $target_path = SITE_ROOT.DS. 'admin' . DS . $this->picture_path();

            return unlink($target_path) ? true : false;



        }else{

            return false;


        }



    }





}




?>

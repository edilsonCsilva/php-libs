<?php 
/*
@access public
@author Edilson Claudino 
@copyright livre.
@exemple  upload.php
@version V.1
*/

class UploadDocs{

    private $dirPath;
    private $size=10000000;
    private $filePrefixedName;
    private $files=[];
    private $allowedExt = array("jpg","jpeg","png","pdf");
    private function uuid(){
        return uniqid();
    }
    public function __construct()
    {
        return $this;
    }

    public function setDirDocuments($dirPath)
    {
        $this->dirPath = $dirPath;
        return $this;
    }

    public function setSize($sizeDocument =10000000)
    {
        $this->size = $sizeDocument;
        return $this;
    }

    public function setPrefixed($filePrefixedName="docs_")
    {
        $this->filePrefixedName = $filePrefixedName;
        return $this;
    }
    
    public function getAutoNameDocuments()
    {
        return sprintf("%s%s",$this->filePrefixedName,$this->uuid());
    }

    public function addDocument($file)
    {
        array_push($this->files,$this->newDocument($file));
        return $this;
    }
 
    private function newDocument($file){
        $fileExt = explode('.',$file['name']);
        $fileActualExt = strtolower(end($fileExt));
        return array(
            "file" =>$file,
            "name" => $file['name'],
            "tmp_name" => $file['tmp_name'],
            "size" => $file['size'],
            "error" => $file['error'],
            "type" => $file['type'],
            "typeextension" =>$fileActualExt
        );
    }
    private function document($file,$save){
        return array(
            "name" => $file['name'],
            "save" =>$save
        );
    }



    public function validateFiles()
    {
        foreach($this->files as $indexDocument =>$document){
            if($document['error'] !=0 ) throw new Exception("Something Went Wrong Please try again!");
            if($document['size'] > $this->size) throw new Exception("File Size Limit beyond acceptance  [ (".$document['size']." bigger then  ". $this->size.")    ] (#error Document:[".$document['name']."] ". ($indexDocument+1)." )");
            if(!in_array($document['typeextension'], $this->allowedExt)) throw new Exception("You can't upload this extention of file!  (#error Document:[".$document['name']."] ". ($indexDocument+1)."");
        }
    }


    public function saveFiles(){
        $this->validateFiles();
        $filesSaved=[];
        foreach($this->files as $indexDocument =>$document){
            
            $fileNemeNew =sprintf("%s_%s.%s",$this->getAutoNameDocuments(),date("Ymd_Hms"),$document['typeextension']);
            //File destination
            $dir= (strlen(trim($this->dirPath)) > 0) ? sprintf("%s/", $this->dirPath) :"";
            $fileDestination = sprintf("%s%s",$dir,$fileNemeNew);
            if(move_uploaded_file($document['tmp_name'], $fileDestination)){
                array_push($filesSaved,$this->document($document,true));
            }else{
                array_push($filesSaved,$this->document($document,false));
            }
        }
        return $filesSaved;
    }
 }

?>

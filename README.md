# php-libs

#exemplos

<?php
require_once("UploadDocs.php");
if(isset($_POST['submit'])){
    try{
        $uploadDocs =  new UploadDocs();
        $uploadDocs->setDirDocuments("Uploads");
        $uploadDocs->addDocument($_FILES['file']);
        $uploadDocs->setPrefixed();
        $uploadDocs->setSize(63676);
        $uploadDocs->saveFiles();
    }catch(Exception $e){
        echo $e->getMessage();
    }
}

/** Resultados do  Upload***/


<?php
require_once("UploadDocs.php");
if(isset($_POST['submit'])){
    try{
        $uploadDocs =  new UploadDocs();
        $uploadDocs->setDirDocuments("Uploads");
        $uploadDocs->addDocument($_FILES['file']);
        $uploadDocs->setPrefixed();
        $uploadDocs->setSize(63676);
        $result=$uploadDocs->saveFiles();
        print_r(["<pre>",$result]);
    }catch(Exception $e){
        echo $e->getMessage();
    }
}

//Resultado

Array ( [0] =>
    [1] => Array
        (
            [0] => Array
                (
                    [name] => 33333.png
                    [save] => 1
                )

        )

)

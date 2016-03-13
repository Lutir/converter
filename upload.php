<?php
if(isset($_POST["submit"])){

    $fileName=$_FILES["resume"]["name"];
    $fileSize=$_FILES["resume"]["size"]/1024;
    // $fileType=$_FILES["resume"]["type"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["resume"]["name"]);
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $fileTmpName=$_FILES["resume"]["tmp_name"];  

    if($fileType == '.doc' || '.docx'){
        if($fileSize<=200){

            //function for upload file
            if(move_uploaded_file($fileTmpName,$target_file)){
              echo "Successful<BR>"; 
              echo "File Name :".basename($_FILES["resume"]["name"])."<BR>"; 
              echo "File Size :".$fileSize." kb"."<BR>"; 
              echo "File Type :".$fileType."<BR>"; 
            }
        }
        else{
            echo "Maximum upload file size limit is 200 kb";
        }
    }
    else{
      echo "You can only upload a Word doc file.";
    }  

}




?> 


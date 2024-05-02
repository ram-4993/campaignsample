<?php
include_once __DIR__ ."/config.php";
$name = preg_replace('/[^A-Za-z\s]/', '', $_POST['name']);
$phone_no = preg_replace('/[^0-9]/', '', $_POST['phone_no']);
$emailid = $_POST['emailid'];
$proffesion = $_POST['proffesion'];
$utm_source = $_POST['utm_source'];
$ipaddress = get_client_ip_server();
$course_id = 1;
if($name && $phone_no && $emailid && $proffesion){

    $nRows = $conn->query("select count(1) from registers WHERE phone_no=$phone_no AND course_id = 1")->fetchColumn(); 
    if($nRows == 0){
        $insert_query = $conn->prepare("INSERT INTO `registers`(`name`,`phone_no`,`emailid`,`proffesion`,`date`,`time`,`user_ip`,`course_id`,`utm`) 
        VALUES (:name,:phone_no,:emailid,:proffesion,:date,:time,:ipaddress,:course_id,:utm)");

        $insert_query->bindValue(":name",$name ?? '');         
        $insert_query->bindValue(":phone_no",$phone_no  ?? '');  
        $insert_query->bindValue(":emailid",$emailid ?? '');         
        $insert_query->bindValue(":proffesion",$proffesion  ?? '');  
        $insert_query->bindValue(":date",$gmdate ?? '');         
        $insert_query->bindValue(":time",$gmtime ?? '');      
        $insert_query->bindValue(":ipaddress",$ipaddress ?? '');     
        $insert_query->bindValue(":course_id",$course_id ?? ''); 
        $insert_query->bindValue(":utm",$utm_source ?? ''); 
        
        $insert_query->execute();
        ;
        if($insert_query->rowCount() > 0){
            echo "success";
        }
        else{
            echo "failed";
        }
    }
    else{
        echo "already";
    }
}
else{
    echo "invalid values";
}


?>
<?php
    require_once('./db.php');
    require_once('./valid.php');
    echo 'i am here';
    
    //$username_err = $password_err = $cpassword_err = "";
    
    if(isset($_POST['submit'])){
       
       $valid_username =  validate_username($username_err,$username,$con);
    }
    $name = $_POST["name"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $valid_password = validate_password($password,$password_err);
    print_r($valid_password);
    $valid_cpassword = validate_cpassword($cpassword,$cpassword_err,$valid_password[1],$valid_password[0]);
    print_r($valid_cpassword);
    check_errors_insert_db( $valid_username[1],$valid_password[1],$valid_username[0],$valid_password[0],$valid_cpassword[0],$con);

    echo 'sql check';
?>
<?php
    
     $username = $password = $cpassword = "";
     $username_err = $password_err = $cpassword_err = "";
    function validate_username($username_err,$username,$con){
       
        $username_data = array("","");
        if(empty(trim($_POST["name"]))){
            $username_err = "Please enter a username";
            $username_data[0]  = $username_err;
            header("Location: index.php?p=signup&err4={$username_err}");
        }elseif(!preg_match('/^[a-zA-Z0-9]+$/',trim($_POST["name"]))){
            $username_err = "username can only contain letters,number,and underscores.";
            $username_data[0]  = $username_err;
            header("Location: index.php?p=signup&err5={$username_err}");
        }else{
             $sql = "SELECT id FROM `user` WHERE `name`=?";
               if($stmt = mysqli_prepare($con,$sql)){
                    mysqli_stmt_bind_param($stmt,"s",$param_username);
                    $param_username = trim($_POST["name"]);

                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_store_result($stmt);

                        if(mysqli_stmt_num_rows($stmt)==1){
                            $username_err = "This username is already taken.";  
                            $username_data[0]  = $username_err;
                            header("Location: index.php?p=signup&err6={$username_err}");
                        }else{
                            $username = trim($_POST["name"]); 
                            $username_data[1]  = $username;
                        }

                    }else{
                        echo "oops! something went wrong. please try again.";
                    }
            
                }

        }
        return $username_data;
    }
    function validate_password($password,$password_err){
        $valid_password = array("","");
        if(empty(trim($_POST["password"]))){
            $password_err = 'Please enter your password';
            $valid_password[0] = $password_err;
            header("Location: index.php?p=signup&err0={$password_err}");
        
        }elseif(strlen(trim($_POST['password']))<6){
            $password_err = 'your password at least 6';
            $valid_password[0] = $password_err;
            header("Location: index.php?p=signup&err1={$password_err}");
         
        }else{
            $password =trim($_POST['password']);
            $valid_password[1] = $password;
        }
        return $valid_password;
    }


    function validate_cpassword($cpassword, $cpassword_err,$password,$password_err){
      $valid_cpassword = array("","");
       if(empty(trim($_POST["cpassword"]))){
            $cpassword_err = 'Please enter your confirm password';
            $valid_cpassword[0] = $cpassword_err;
            header("Location: index.php?p=signup&err2={$cpassword_err}");
       }else{
            $cpassword = $_POST["cpassword"];
            if( ($password != $cpassword)&& empty($password_err)){
                   $cpassword_err =  'Password did not match!'; 
                   $valid_cpassword[0] =  $cpassword_err;
                   header("Location: index.php?p=signup&err3={$cpassword_err}");
            }

        }
             return $valid_cpassword;
    }
    


    function check_errors_insert_db($username,$password,$username_err,$password_err,$cpassword_err,$con){
        if(empty($username_err)&&empty($password_err)&&empty($cpassword_err)){
            $sql = "INSERT INTO `user` (`name`,`password`) VALUES (?,?)";
            echo 'insert sql';
            if($stmt = mysqli_prepare($con,$sql)){
                mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
                echo 'bind sql';
                $param_username = $username;

                
                $param_password = password_hash($password,PASSWORD_DEFAULT);
                if(mysqli_stmt_execute($stmt)){
                    $tip = 'your signup successfully!';
                    echo 'signup,success';
                    header("Location:index.php?p=signup&msg={$tip}");  
                }else{
                    echo 'Oops is wrong try agin laster.';
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($con);
    }


?>
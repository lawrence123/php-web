<?php
session_start();

if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === TRUE){
    header("Location: index.php?p=login");
    exit;
}
require_once('db.php');

$username = $password = "";
$username_err = $password_err = $login_err = "";

if(isset($_POST['login'])){
        //check if username is empty
        if(empty(trim($_POST["name"]))){
            $username_err = "Please enter username.";
           header("Location: index.php?p=login&err0={$username_err}");
        }else{
            $username = trim($_POST["name"]);
            echo $username;
        }

        //Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
            header("Location: index.php?p=login&err1={$password_err}");
        }else{
            $password = trim($_POST["password"]);
        }
    
        //validate credentials
        if(empty($username_err)&&empty($password_err)){
            $sql = "SELECT * FROM `user` WHERE name=?;";
      
            if($stmt = mysqli_prepare($con,$sql)){
                //bind variables to the prepared statement as parameter
               
                mysqli_stmt_bind_param($stmt,"s",$username);
             
                if(mysqli_stmt_execute($stmt)){
                     mysqli_stmt_store_result($stmt);
                   
                    
                   
                    print_r(mysqli_stmt_num_rows($stmt));
                    if(mysqli_stmt_num_rows($stmt)==1){
                        mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
                          
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password,$hashed_password)){
                                session_start();
                                
                                $_SESSION['is_login'] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"]=$username;
                                
                        
                                header("Location: index.php?p=index&msg='Login successfully!'");
                            }else{
                                $login_err = "Invalid username or password.";
                                header("Location: index.php?p=login&err2={$login_err}");
                            }
                        }

                    }else{
                        $login_err = "Invalid username or password.";
                        header("Location: index.php?p=login&err3={$login_err}");
                    }
                }else{
                    $oops = 'Oops! Something went wrong. Please try again .';
                    header("Location: index.php?p=login&err4={$oops}");
                }
                mysqli_stmt_close($stmt);
            }
            
        }
        mysqli_close($con);
    }
?>
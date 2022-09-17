<?php
    require_once('./db.php');
    session_start();
   

    if(isset($_GET['p'])){
        $p = $_GET['p'];
    }else{
        $p='';
    }


?>
<style>
    .login{
        border-radius:5px;
        width:350px;
        height:330px;
        margin:auto;
        border:groove;
        padding:20px ;
    }
    .footer{
        color: red;
    }
    .sign,.loginmsg{
        
        padding-left:18%;
        padding-top: 20px;
       
        
    }
    .msg{
        padding-left:28%;
        margin-top: 20px;
    }
    

   
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>LawBuilding</title>
</head>
<body>
    <header>
        <?php if(isset($_SESSION["is_login"]) && $_SESSION["is_login"] == true):?>
            <ul>
                <li><a href="?p=index">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li>Hi,<?php echo $_SESSION["username"]?></li>
            </ul>
        <?php else:?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="?p=login">Login</a></li>
                <li><a href="?p=signup">Signup</a></li>   
            </ul>
        <?php endif?>
        
        
    </header>
    <main>
             
        <article id="main">
            <!--  no login home page-->
            <?php if($p==''):?>
                <div>hello</div>
            <?php endif?>
           <!-- signup page-->
            <?php if($p=='signup'): ?>
                    <br><br>
                    <div id="signup" class="signup"> 
                            <?php  
                                for($i=0;$i<7;$i++){
                                    $d = "err{$i}";
                                    echo (!empty($_GET[$d]))?'<div class="tip"><li>'.$_GET[$d].'</li></div>':'';
                                }
                            ?>             
                        <h1>Sign up</h1>
                        <form action="sigup.php" method="POST">
                            <label for="name">Name</label>
                            <input type="text" name="name" > 
                        
                            <label for="password">Password</label> 
                            <input type="password" name="password"> 
                        
                            <label for="cpassword"> Confirm password</label>
                            <input type="password" name="cpassword">
                            <br>
                            <input type="submit" name="submit" value="Sign up">
                        </form>
                        <div class="loginmsg">
                            <p>If you already have account</p> 
                            
                             <div class="msg">
                             <a href="index.php?=login" style="color: blue;">Login in</a>
                                <?php echo (!empty($_GET['msg']))? $_GET['msg']:''?> 
                            </div>
                        </div>
                       
                        
                    </div>
            <?php endif ?>    
               <!-- is login home page-->                  
            <?php if($p=='index'): ?>

                <?php if(isset($_SESSION["is_login"]) && $_SESSION["is_login"] == true):?>
                    <div> <h1>home</h1></div>
                    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
                <?php else:?>
                <?php   header("location: index.php?p=login");
                endif ?>

            <?php endif ?>
            <!-- login page-->
            <?php if($p=='login'): ?>
                <br>
                <div  class="login">
                    <?php  
                        for($i=0;$i<4;$i++){
                            $d = "err{$i}";
                            echo (!empty($_GET[$d]))?'<div class="tip"><li>'.$_GET[$d].'</li></div>':'';
                        }
                    ?> 
                    <form action="login.php" method="POST">
                        <label for="name">Name</label>
                        <input type="text" name="name">
                        <label for="password">Password</label>
                        <input type="password" name="password"/>
                        <input type="submit" name="login" value="Login">
                        <div class="sign">
                            <a href="index.php?p=signup" style="color:blue;">Sign up</a> 
                        </div>
                    
                    </form>
                </div>
            <?php endif ?>
        </article>

        <nav>side Nav</nav>
        <aside>Aside</aside>
    </main>


    <footer>
        <div class="footer"> footer</div>
    </footer>

</div>
</body>
</html>
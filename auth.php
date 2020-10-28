<?php
session_start([
    'cookie_lifetime'=>300 // 5 min
]);
$error = false;
$_SESSION['loggedin'] = "";
if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {

    if('admin' == $_POST['username'] && 'rabbit' == $_POST['password']) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = true;
        $_SESSION['loggedin'] = false;
    }

}
if( isset($_POST['logout']) ) {
    $_SESSION['logout'] = false;
    session_destroy();

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FORM EXAMPLE</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <style>
        body{
            margin-top: 30px;
            font-family: "Lobster", serif;
        }

    </style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>LOGIN FORM</h2>
            </div>
        </div>
        <div class = row>
            <div class = "column column-60 column-offset-20">
            <?php
                if(true == $_SESSION['loggedin']) {
                    ?>
                    <blockquote>
                        Welcome Admin, Have A Nice Day
                    </blockquote>
                    <?php        
                } else {
                    echo sha1('rabbit')."<br>";
                    ?>
                    <blockquote>
                        Hello Stranger, Please Login Below 
                    </blockquote>
                    <?php   
                }
            ?>
            </div>
        </div>
        <?php
            if( $error ) {
                ?>
                <div class="row">
                    <div class="column column-60 column-offset-20">
                        <blockquote>
                            username and password didn't match
                        </blockquote>
                    </div>
                </div>
                <?php   
            }
            if( false == $_SESSION['loggedin'] ):
                ?>
                <div class="row" style="...">
                    <div class="column column-60 column-offset-20">
                        <form method="POST">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username">
                            <label for="password">Password</label>
                            <input type= "password" name="password" id="password">
                            <button type="submit" class="button-primary" name="submit">Log In</button>
                        </form>
                    </div>
                </div>
                <?php
            else:
                ?>
                <div class="row">
                    <div class="column column-60 column-offset-20">
                        <form action="/project%20exercises/Projects/CRUD/auth.php" method="POST">
                            <input type="hidden" name="logout" value="1">
                            <button type="submit" class="button-primary" name="submit">Log Out</button>
                        </form>
                    </div>
                </div>    
                <?php
                echo $_POST['logout'];
            endif;
        ?>
</div>
</body>
</html>
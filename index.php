<?php
require_once 'UserApplication.php';
?>


<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>ARMS Login</title>
        <link href="Style/style.css" rel="stylesheet" type="text/css" media="screen" />
        <style>
            body{
                background: url(Style/images/img01.jpg) repeat;
            }
        </style>
    </head>

    <body>

        <div id="wrapper">
            <div id="login-wrapper">
                <div id="header" class="container">
                    <div id="logo">
                        <h1><a href="#">Login </a></h1>
                    </div>
                </div>	

                <div id="page">

                    <form method="post" action="UserApplication.php">

                        <div style="margin:50px;">

                            <p>Username:</p>
                            <p><input name="accID" type="Text" size="35"value="<?php echo $validator->getValue("accID"); ?>"/> 
                                <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("accID") . "</span>"; ?> 
                            </p>

                            <p>Password:</p>
                            <p><input name="accPass" type="password" size="35" value=""> 
                                <?php echo '<span=\"color:#ff0000;\">' . $validator->getError("password") . '</span>'; ?>
                            </p>
                            <p>
                            <center><input type="submit" name="login" value="login" class="button-style">
                                </p></center>
                        </div>
                    </form>	

                    <div style="clear: both;">&nbsp;</div>
                </div>



            </div>
            <!-- end #page --> 

        </div>


        <!-- end #footer -->
    </body>
</html>


<?php
require_once 'UserApplication.php';
?>

<!DOCTYPE html>
<html>

    <head>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>ARMS</title>
        <link href="Style/style.css" rel="stylesheet" type="text/css" media="screen" />
    </head>

    <body>

        <div id="wrapper">
            <div id="header-wrapper">
                <div id="header" class="container">
                    <div id="logo">
                        <h1><a href="#">ARMS</a></h1>
                    </div>
                    <div id="menu">
                        <ul>
                            <li class="current_page_item"><a href="adminHome.php">Home</a></li>
                            <li><a href="ArmsStatus.php">ARMS Status</a></li>
                            <li><a href="UserApplication.php?logout=1">Logout</a>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- end #header -->

            <div id="page">
                <div>
                    <?php
                    if ($userService->logged_in) {
                        echo '<h3 style="margin-bottom:15px;">Hello ' . $userService->name . '</h3>';
                    }
                    ?> 

                    <fieldset>
                        <legend> <h2 class="title">Add Account:</h2> </legend>

                        <?php
                        if ($validator->num_errors > 0) {
                            echo "<span style=\"color:#ff0000;\">" .
                            $validator->num_errors . " error(s) found</span>";
                        }
                        ?>
                        <form method="post" action="UserApplication.php">

                            <!-- Users -->


                            <p>
                                <span class="title" style="margin-right: 25px;"> User ID:</span>
                                <input name="accID" type="Text" value="<?= $validator->getValue("accID") ?>" required />
                                <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("accID") . "</span>"; ?>
                            </p>

                            <p>
                                <span class="title" style="margin-right: 8px;"> Password:</span>
                                <input name="accPass" type="password" value="" required />
                                <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("accPass") . "</span>"; ?>
                            </p>

                            <p>
                                <span class="title" style="margin-right: 3px; "> User Name:</span>
                                <input name="name" type="Text" value="<?= $validator->getValue("name") ?>" required />
                                <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("name") . "</span>"; ?>
                            </p>

                            <p>
                                <span class="title" style="margin-right: 17px;"> Job Title:</span>
                                <input name="jobTitle" type="text" value="<?= $validator->getValue("jobTitle") ?>">
                                <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("jobTitle") . "</span>"; ?>
                            </p>

                            <p>
                                <span class="title" style="margin-right: 17px;"> Account Type:</span>
                                <input type="radio" name="accType" value="1" />Admin
                                <input type="radio" name="accType" value="0" selected/>Regular User
                            </p>

                            <center> <input type="submit" name="add" value="Add Account" class="button-style"> </center>

                    </fieldset>

                    </form>

                </div>

                <div style="clear: both;">&nbsp;</div>
            </div>
            <!-- end #page --> 
        </div>
    </body>
</html>

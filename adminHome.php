<?php
require_once 'UserApplication.php';
$result = $userService->getAllUsers();
?>


<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>ARMS Home</title>
        <link href="Style/style.css" rel="stylesheet" type="text/css" media="screen" />
    </head>

    <body>
        <?php
        if (isset($validator->statusMsg)) {
            echo '<script type="text/javascript">window.alert("' . $validator->statusMsg . '"); </script>';
        }

        //Selected user:
        $user = (isset($_POST['users']) ? $_POST['users'] : "");

        //Update or delete user
        if ($user != "") {
            if ($validator->idExists($user)) {
                if (isset($_POST['delete'])) {//Delete user account:
                    header('Location:UserApplication.php?delete=' . $user);
                } else if (isset($_POST['update'])) {//update user account:
                    header('Location:updateUser.php?uID=' . $user);
                }
            }
        } else {
            if (isset($_POST['delete']) || isset($_POST['update'])) {
                echo '<script type="text/javascript"> window.alert("Please select a user first to update or delete his account"); </script>';
            }
        }
        ?>

        <div id="wrapper">
            <div id="header-wrapper">
                <div id="header" class="container">
                    <div id="logo">
                        <h1><a href="#">ARMS</a></h1>
                    </div>
                    <div id="menu">
                        <ul>
                            <li class="current_page_item"><a href="#">Home</a></li>
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
    echo '<h3 style="margin-bottom:15px;">Hello ' . $userService->name . '!</h3>';
}
?> 

                    <center><fieldset style="width: 700px;">
                            <legend> <h2 class="title">User Accounts:</h2> </legend>

                            <form method="post" action="#">

                                <!-- Users -->

                                <div>
<?php
if ($result != false) {
    foreach ($result as $row) {

        echo'<p><input type="radio" name="users" value="' . $row['accID'] . '"><span class="title">' . $row['name'] . '</span></p>';
    }
} else {
    echo '<p class="title"> There are no users in the database yet</p>';
}
?>
                                </div>

                        </fieldset>

                        <a href="addUser.php" class="button-style">Add User</a>

<?php
if ($result != false) {
    echo '<input type="submit" name="update" value="Update User Info" class="button-style" />';
    echo '<input type="submit" name="delete" value="Delete User" class="button-style" onclick="return confirm(\'Are you sure you want to delete user?\')">';
}
?>

                    </center>

                    </form>


                </div>

                <div style="clear: both;">&nbsp;</div>
            </div>
            <!-- end #page --> 
        </div>

    </body>
</html>
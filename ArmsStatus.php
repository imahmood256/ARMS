<?php
require_once 'UserApplication.php';
require_once 'TaskApplication.php';

$status = "free";
if (($taskService->currentTask) == true) {
    $TaskTime = $taskService->taskTime;
    $LeftTime = $taskService->leftTime;
    $destenation = $taskService->dest;
    $status = "busy";
    $creator = $taskService->getTaskCreator($taskService->taskId);
    if ($creator) {
        $tCreator = $creator['mUserID'];
    } else {
        $tCreator = "";
    }
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>ARMS</title>
        <link href="Style/style.css" rel="stylesheet" type="text/css" media="screen" />

        <script>
            var t =<?php echo "$LeftTime"; ?>;
            var myVar = setInterval(function () {
                myTimer()
            }, 60000);

            function myTimer() {
                t = t - 1;
                document.getElementById("time").innerHTML = t;
                if (t == 0)
                    location.reload();
            }
        </script>
    </head>



    <div id="wrapper">
        <div id="header-wrapper">
            <div id="header" class="container">
                <div id="logo">
                    <h1><a href="#">ARMS Update Info</a></h1>
                </div>
                <div id="menu">
                    <ul>
                        <?php
                        if ($userService->admin == "1") {
                            echo'<li><a href="adminHome.php">Home</a></li>' .
                            '<li class="current_page_item"><a href="ArmsStatus.php">ARMS Status</a></li>';
                        }
                        ?>
                        <li><a href="UserApplication.php?logout=1">Logout</a></li>
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
                    <legend> <h2 class="title">ARMS Status:</h2> </legend>
                    <h3 style="margin-bottom:15px;" class="title">ARMS is now <?php echo $status; ?>:</h3>

                    <!-- if there is task performed-->
                    <?php
                    if ($status == "busy") {
                        echo '<div class="entry">';
                        echo '<p> <span class="title">Destination: </span>' . $destenation . '</p>';
                        echo'<p> <span class="title">Estimated Task Time: </span>' . $TaskTime . ' min</p>';
                        echo'<p> <span class="title" >Estimated Left Time:</span> <span id="time">' . $LeftTime . '</span> min</p>';

                        //if the user is the task creator:
                        if ($tCreator == $_SESSION['uid']) {
                            echo '<form method="post" action="TaskApplication.php">';
                            echo '<input type="submit" name="stop" value="Stop Task" class="button-style">';
                            echo '</form>';
                            echo '</div>';
                        }
                    }
                    ?>

                    <div style="clear: both;">&nbsp;</div>

                    <div class="entry">
                        <img src="Style/images/map.png" height="300" width="300">
                    </div>

                    <div class="entry">
                        <img src="Style/images/video.png" height="300" width="300">
                    </div>
                </fieldset>
            </div>

            <div style="clear: both;">&nbsp;</div>
        </div>
        <!-- end #page --> 
    </div>

</body>
</html>
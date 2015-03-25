<?php
require_once 'UserApplication.php';
$id= $_GET['uID'];
$userInfo= $userService->getUser($id);
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
                        <h1><a href="#">ARMS Update Info</a></h1>
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
                        echo '<h3 style="margin-bottom:15px;">Hello '.$userService->name.'</h3>';
                    }
                    ?> 

<fieldset>
                <legend> <h2 class="title">Update Account:</h2> </legend>
				<?php
                                $uname="";
                                ($validator->getValue("name") != "") ? $uname= $validator->getValue("name"): $uname= $userInfo['name']; 
                                
                                $jt="";
                                ($validator->getValue("jobTitle") != "") ? $jt= $validator->getValue("jobTitle"): $jt= $userInfo['jobTitle']; 
                               ?>
				<form method="post" action="UserApplication.php">

					<p>
					<span class="title" style="margin-right: 25px;"> User ID:</span>
                                        <input name="id" type="Text" value="<?php echo $userInfo['accID']; ?>" disabled/>
                                        <input type="hidden" name="accID" value="<?php echo $userInfo['accID']; ?>" />
					</p>
                                        
					
					<p>
					<span class="title" style="margin-right: 8px;"> New Password: 
					<input name="accPass" type="password" value=""/>(Leave it blank if you don't want to change your password)</span>
                                        <p><?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("accPass") . "</span>"; ?> </p>
                                        </p>
					
					<p>
					<span class="title" style="margin-right: 3px;"> User Name:</span>
					<input name="name" type="Text" value="<?php echo ''.$uname.'';?>"/>
                                        <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("name") . "</span>"; ?>
                                        </p>
					
					<p>
					<span class="title" style="margin-right: 17px;"> Job Title:</span>
                                        <input name="jobTitle" type="text" 
                                        value="<?php echo ''.$jt.'';?>" required>
                                         <?php echo "<span style=\"color:#ff0000;\">" . $validator->getError("jobTitle") . "</span>"; ?>
                                        </p>
				<center> <input type="submit" name="update" value="Update Account" class="button-style"> </center>
				
				</fieldset>
				
				</form>
					
			</div>
		
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end #page --> 
</div>
        
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>KSA&D Interactive Passwords</title>


	<link media="all" href="/styles/global.css" type="text/css" rel="stylesheet">
	<link media="all" href="/styles/main.css" type="text/css" rel="stylesheet">
	<link media="all" href="/styles/users.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/javascript/jquery.min.js"></script>
    <style>
    .center_module{
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
</style>
</head>
<body>
	<div id="wrapper" class="sub news">
        <div id="topHeader">
            <?php include('incl/topHeader.incl.php'); ?>
        </div>
        <div id="topNav">
            <?php include('incl/topNav.incl.php'); ?>
        </div>
        <div class="left" id="main">
        	<div class="white" id="middle">
        		<div id="center_content">
        			<div class="center_module" id="news_main">
                    
                   		<div id="user_profile">
                        	<form id="frmUsers" method="post">
                                <?php if(isset($message) && $message) {?>                         
                            	<div class="form_row">
                                	<div class="form_element">
                                    	<label>Note:</label>
                                    	<p class="pw_note"><?php echo $message;?></p>
                                    </div>
                                </div>
                                <?php }?>
                            	<div class="form_row">
                                	<div class="form_element">
                                    	<label for="name">Name</label>
                                        <input type="text" id="name" name="name" value="<?php echo (isset($user->fullname))?$user->fullname:'';?>" />
                                    </div>
                                </div>
                            	<div class="form_row">
                                	<div class="form_element">
                                    	<label for="username">Username</label>
                                        <input type="text" id="username" name="username" value="<?php echo (isset($user->fullname))?$user->username:'';?>" />
                                    </div>
                                </div>
                                <?php if(isset($user->username)) {?>                         
                            	<div class="form_row">
                                	<div class="form_element">
                                    	<label>Note:</label>
                                    	<p class="pw_note">Leave password fields blank to remain unchanged.</p>
                                    </div>
                                </div>
                                <?php }?>
                            	<div class="form_row">
                                	<div class="form_element">
                                    	<label for="password">Password</label>
                                        <input type="text" id="password" name="password" />
                                    </div>
                                </div>
                            	<div class="form_row">
                                	<div class="form_element">
                                    	<label for="conf_password">Confirm Password</label>
                                        <input type="text" id="conf_password" name="conf_password" />
                                    </div>
                                </div>
                            	<div class="form_row">
                                	<div class="form_element center_text">
                                    	<input type="hidden" name="id" value="<?php echo (isset($user->fullname))?$user->id:'';?>"/><input type="submit" value="Submit" /> <input type="button" onClick="window.location='/index.php/users/'" value="Reset" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    	
						<div id="recentActivity">
                        	<h2>User Manager</h2>
                            <table class="admin users" id="tableResults">
                                <thead>
                                    <tr class="head">
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $u) {?>
                                    <tr>
                                        <td><?php echo $u->fullname;?></td>
                                        <td><?php echo $u->username;?></td>
                                        <td><a href="?user=<?php echo $u->id;?>">Edit</a></td>
                                        <td><a href="/index.php/users/delete/?user=<?php echo $u->id;?>" onClick="return confirm('Are you sure you want to remove this user?')">Delete</a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
    
    
    
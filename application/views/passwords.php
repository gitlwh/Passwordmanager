<?php
if (isset($_GET['client'])) {
    $client_id = $_GET['client'];
} else {
    $client_id = -1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>KSA&D Interactive Passwords</title>


    <link media="all" href="/styles/global.css" type="text/css" rel="stylesheet">
    <link media="all" href="/styles/main.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/javascript/jquery.min.js"></script>

    <script type="text/javascript">
        function goTo() {
            var sE = null, url;
            if (document.getElementById) {
                sE = document.getElementById('urlList');
            } else if (document.all) {
                sE = document.all['urlList'];
            }
            if (sE && (url = sE.options[sE.selectedIndex].value)) {
                location.href = url<?php echo (isset($_GET['bypass_auth'])) ? '+"&bypass_auth=1"' : '';?>;
            }
        }
        function myFunction() {
            //console.log("hello");
          // Declare variables 
          
          var input, filter, table, tr, td, i, j;
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          tr = document.getElementsByClassName("listall");

          // Loop through all table rows, and hide those who don't match the search query
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            j=0;
            while(j<td.length){
                if(td[j]){
                  if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                  } 
                }
                j++;
            }
            if(j==td.length){
                tr[i].style.display = "none";
            }else{
                tr[i].style.display = "";
            }
          }
        }

        $(document).ready(function () {
            $('#urlList').bind('change', function () {
                goTo();
            });
        });
    </script>
    <style>
        .client{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .description{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .username{
            width:90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .password{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .url{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .comments{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .edit{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .delete{
            width: 90px;
            max-width: 90px;
            word-wrap: break-word;
        }
        .center_module{
            display: block;
            margin-left: auto;
            margin-right: auto;
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
                <div class="center_module" id="news_main" >
                    <div id="updatesSince">
                        <?php 
                        $query = $this->db->get('passwords');



                        //$result = mysql_query("SELECT * FROM passwords");
                        //$num_rows = mysql_num_rows($result); 
                        $num_rows=count($query->result());
                        ?>
                        <h2>Password Counter</h2>
                        <p><?php echo $num_rows; ?></p>
                    </div>
                    <div id="welcomeText">
                        <h2>Password Search</h2>
                        <form class="jqTransform">
                            <table>
                                <tr class="heading">
                                    <td>Clients</td>
                                    <!-- <td>Password Type</td> -->
                                </tr>
                                <tr>
                                    <td>
                                        <select id="urlList">
                                            <option value="#">--- Select a Client ---</option>
                                            <?php $query = $this->db->query("SELECT * FROM clients ORDER BY name ASC");
                                            foreach ($query->result() as $row) {
                                                echo '<option value="/index.php/passwords?client=' . $row->id . '">' . $row->name . '</option>';
                                            }

                                            ?>
                                        </select>

                                        <?php //<input type="button" value="Go!" onclick="goTo();"> ?>or <a
                                            href="/index.php/passwords/add_client">add new client</a>
                                        <?php $query = $this->db->query("SELECT * FROM clients WHERE id = '$client_id'"); ?>

                                    </td>
                                    
                                    
                                    <!-- <td>
                                        <select id="selSearchPasswords">
                                            <option value="Select Password Type..." selected="true">Select Password Type...</option>
                                        </select>
                                    </td> -->
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for key words...">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div id="recentActivity">
                        <?php $query = $this->db->query("SELECT * FROM clients WHERE id = '$client_id'");
                        if(sizeof($query->result())==0){
                            echo '<h2>Passwords for all clients</h2>';
                        }

                        foreach ($query->result() as $row) {
                            echo '<h2>Passwords for ' . $row->name . '</h2>';
                        }
                        ?>
                        <table class="admin" id="tableResults">
                            <thead>
                            <tr class="head">
                                <th>client</th>
                                <th>Description</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>URL</th>
                                <th>Comments</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                            <tr id="inputbar">
                                <form action="#" method="POST">
                                    <td>

                                    <select name="clientname" class="client">
                                        <option value="">--- Select a Client ---</option>
                                        <?php 
                                        if($client_id == -1){
                                            $query = $this->db->query("SELECT * FROM clients ORDER BY name ASC");
                                        ?>


                                            
                                            <?php 
                                            foreach ($query->result() as $row) {
                                                echo '<option value="'.$row->name.'">' . $row->name . '</option>';
                                            }

                                            ?>
                                        <?php
                                            }else{
                                                foreach ($query->result() as $row) {
                                                    if($row->id==$client_id)
                                                echo '<option value="'.$row->name.'" selected>' . $row->name . '</option>';
                                                else
                                                    echo '<option value="'.$row->name.'">' . $row->name . '</option>';
                                            }
                                            }
                                        ?>
                                        </select>
                                    <td><input type="text" name="description" class="description" /></td>
                                    <td><input type="text" name="username" class="username" /></td>
                                    <td><input type="text" name="password" class="password" /><br/><input type="text" name="confirm-password" class="password"/></td>
                                    <td><input type="text" name="url" class="url" /></td>
                                    <td><input type="text" name="comments" class="comments" /></td>
                                    <td><input type="submit" value="Add Password"/></td>
                                    <td><input type="hidden" name="client" value="<?php echo $client_id; ?>"/></td>
                                </form>
                            </tr>
                            <?php 

                            if($client_id==-1){
                                $query = $this->db->query("SELECT passwords.id, name, client_id, username, aes_decrypt(encrypted_password,'ksand3102') password, passwords.url, description, comments  
                                    FROM passwords 
                                    INNER JOIN clients on clients.id =passwords.client_id ORDER BY description ASC");
                            }else{
                                $query = $this->db->query("SELECT passwords.id, name, client_id, username, aes_decrypt(encrypted_password,'ksand3102') password, passwords.url, description, comments  
                                    FROM passwords 
                                    INNER JOIN clients on clients.id =passwords.client_id WHERE client_id = '$client_id' ORDER BY description ASC");
                            }


                             ?>
                            <?php
                            if ($query->num_rows() > 0) {
                                foreach ($query->result() as $row) {

                                    echo '<tr class="listall">';
                                    echo '<td class="client"><a href="/index.php/passwords?client='.$row->client_id.'">'. $row->name . '</a></td>';
                                    echo '<td class="description">' . $row->description . '</td>';
                                    echo '<td class="username">' . $row->username . '</td>';
                                    echo '<td class="password">' . $row->password . '</td>';
                                    echo '<td class="url"><a href="'.$row->url.'" target="_blank">' . $row->url . '</a></td>';
                                    echo '<td class="comments">' . $row->comments . '</td>';
                                    
                                    echo '<td class="edit"><a href="/index.php/passwords/edit_password?id=' . $row->id . '&client=' . $client_id . '">Edit</a>';
                                    echo '<td class="delete"><a href="/index.php/passwords/delete_password?id=' . $row->id . '&client_id=' . $client_id . '">Delete</a>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    if($client_id!=-1){

                    ?>
                    <div>
                        <a href="passwords" style="display: inline-block;
    margin: 5px;">Back to all</a>
                    </div>

                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
</body>
</html>

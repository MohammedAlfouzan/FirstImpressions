<html>
<?php

$name_error;
if(isset($_POST["name"]))
{
  $user_name = "ma2594";
  $password = "5105780";
  $server = "tund.cefns.nau.edu";

  $conn = mysqli_connect($server, $user_name, $password, "ma2594");

  if($conn->connect_error)
  {
    die("Connection failed " . mysqli_connect_error());
  }
  
  if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["emailC"]) || empty($_POST["password"]) || empty($_POST["passwordC"]))
  {
  	$name_error = "Please fill out empty boxes";
  }

 	
  $name = $_POST["name"];
  $email = $_POST["email"];
  $emailC = $_POST["emailC"];
  $password = $_POST["password"];
  $passwordC = $_POST["passwordC"];

  
  /* does not check if the username already exists */
  $get_u = mysql_query("SELECT * FROM profile_tbl WHERE name='$name'");
  
  if (mysql_num_rows($get_u) > 0)
  {
  	echo "<h1> Username already exists </h1>";
  }
  

  $add = "INSERT INTO profile_tbl (name, email, password) VALUES ('$name','$email','$password')";
  if($conn->query($add) === TRUE)
  {
    echo "<h1> Data submitted </h1>";
    
  }
  $conn->close();

}

/*
<div class="signature">
<pre class="note">
Contents of the signature's note field goes here.
</pre>
<div class="name">
Contents of the signature's name field goes here.
</div>
</div>
*/
?>
    <head>
        <link rel = "stylesheet" type="text/css" href="User_SignsUp.css">
    </head>
    <div id = "background">
    <div id = "div1"> First Impression </div>
    <div id = "box1">
    <div class = "boxs">
<form name="myform" class = "boxs" action = "User_SignsUp.php" method = "POST">
	<span class = "error"><?= $name_error?></span>
	<h1> </h1>
	 Username: <input type = "text" name = "name">
     Email: <input type = "text" name = "email" placeholder = 'you@example.com'/>
     Email Confirmation: <input type = "text" name = "" >
   	 Password: <input type = "password" name = "password">
   	 Password confirmation: <input type = "password" name = "">
    <input type = "submit" name = "signup-button" value = "Sign up"/>
</div>
</div>
  </form>
</html>

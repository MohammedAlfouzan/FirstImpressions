<html>
<?php

$name_error;
$email_error;
$password_error;

if(isset($_POST["name"]))
{
  $user_name = "ma2594";
  $password = "5105780";
  $server = "tund.cefns.nau.edu";

  $conn = mysqli_connect($server, $user_name, $password, "ma2594");
  $get_u = mysqli_query($conn, "SELECT * FROM profile_tbl WHERE name='$name'");
  
  if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["emailC"]) || 
  					empty($_POST["password"]) || empty($_POST["passwordC"]))
  {
  	$name_error = "Please fill out the empty box/boxes";
  	
  }
  else if ($_POST["email"] != $_POST["emailC"])
  {
  	$email_error = "emails does not match";
  }
  
  else if ($_POST["password"] != $_POST["passwordC"])
  {
  	$password_error = "passwords does not match";
  }
    /* does not check if the username already exists */
  else if (mysql_num_rows($get_u) != 0)
  {
  	$name_error = "Username already exists";
  }
  else
  {
  
  $name = $_POST["name"];
  $email = $_POST["email"];
  $emailC = $_POST["emailC"];
  $password = $_POST["password"];
  $passwordC = $_POST["passwordC"];


  $add = "INSERT INTO profile_tbl (name, email, password) VALUES ('$name','$email','$password')";
  if($conn->query($add) === TRUE)
  {
    echo "<h1> Data submitted </h1>";
    
  }
  $conn->close();

}
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
    <div id = "div1"> First Impression </div>
    <div id = "box1">
    <div class = "boxs">
    
<form name="myform" class = "boxs" action = "User_SignsUp.php" method = "POST">
	<span class = "error"><?= $name_error?></span>
	<span class = "error"><?= $email_error?></span> 
	<span class = "error"><?= $password_error?></span> 
	<h1> </h1>
	 Username: <input type = "text" name = "name">
     Email: <input type = "text" name = "email" placeholder = 'you@example.com'/>
     Email Confirmation: <input type = "text" name = "emailC" > 
   	 Password: <input type = "password" name = "password">
   	 Password confirmation: <input type = "password" name = "passwordC">
   	<select name = "category">
   	<option value = "0" selected = "selected"> Select a category </option>
    <option value = "fashCategory"> Fashion </option>
    <option value = "foodCategory"> Food </option>
    <option value = "histCategory"> History </option>
    <option value = "natuCategory"> Nature </option>
    <option value = "peopCategory"> People </option>
    <option value = "placCategory"> Places </option>
    <option value = "popCategory"> Pop culture </option>
    <option value = "otheCategory"> Other </option>
    </select>
    <h1> </h1>
    <input type = "submit" name = "signup-button" value = "Sign up"/>
    
    </form>
</div>
</div>
</html>

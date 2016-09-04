<?php include('includes/config.php'); 

if(isset($_POST['check']) == true)
{
	
	$subject = trim($_POST['subject']);
	$message = trim($_POST['message']);
	$from = 'noreply@akmedia.com';
	$reply = 'reply@akmedia.com';

	foreach($_POST['check'] as $key => $value)
	{
		// Set content-type for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: <".$from.">\r\n";
		$headers .= "Reply-To: ".$reply."";
 		if(@mail($value,$subject,$message,$headers))
		{	
			echo '<div class="container-fluid" style="width:50%;">
				  <div class="alert alert-success fade in">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
 		    echo '<strong>Success! </strong>'; 
			echo ' Mail has been Successfully sent to '.$value.'</br>';
			echo '</div></div>';
		} 
	}
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Email to Multiple Users</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="js/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <script type="text/javascript" language="javascript">
	function checkedbox(element) { 
		var checkboxes = document.getElementsByTagName('input');
		if (element.checked) {
			 for (var i = 0; i < checkboxes.length; i++) {
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = true;
				 }
			 }
		} else {
			 for (var i = 0; i < checkboxes.length; i++) {
				 console.log(i)
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
				 }
			 }
		}
	}
	</script>
<script src="js/tinymce/js/tinymce/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
</head>

<body>

<div class="container-fluid" style="width:50%;">
  <center><h3>Send Email to Multiple Users</h3></center>
  <p>Please Select Users</p> 
  
  <form method="post" action="">
	<?php
 
	// Retrieve Email from Database
	$getemail = mysql_query("SELECT * FROM Email_Users");
	
	if (!$getemail) die('MySQL Error: ' . mysql_error());
	
	echo '<table class="table table-bordered">';
	echo "<thead>
	      <tr>
	      <th><input type='checkbox' onchange='checkedbox(this)' name='chk'/></th>
	      <th>Username</th>
	      <th>Email</th> 
	      </tr>
    	  </thead>";
		
	if (mysql_num_rows($getemail) == 0) {    
	echo "<tbody><tr><td colspan='3'>No Data Avaialble</td></tr></tbody>";    
	} 
 
	while ($row = mysql_fetch_assoc($getemail)) {     
		echo "<tbody><tr><td><input value='".$row['email']."' type='checkbox' name='check[]'/></td>";	
		echo "<td >".$row['username']."</td>";
		echo "<td >".$row['email']."</td></tr></tbody>";
	} 
	echo "</table>";
	?>
	<p>Email Subject:<input type="text" name="subject" value=""  class="form-control"/></p>
	<p>Email Content:<textarea name="message" cols="40" rows="6"></textarea></p>
	<center><input type='submit' name='submit' value='Send Email Now' class="btn btn-primary btn-block"/>
	</center>
	<br>
</div>
</body>
</html>
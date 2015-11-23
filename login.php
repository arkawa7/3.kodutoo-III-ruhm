<?php
	// LOGIN.PHP
	
	require_once("functions.php");
	$email_error = "";
	$password_error = "";
	$first_name_error = "";
	$last_name_error = "";
	$email_add = "";
	$email_add_error = "";
	$email_confirm = "";
	$email_confirm_error = "";
	$password_one = "";
	$password_one_error = "";
	$password_confirm = "";
	$password_confirm_error = "";
	$First_name = "";
	$Last_name = "";
	$login_email = "";
	$login_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){ 
			
			echo "vajutas login nuppu!";
			if ( empty($_POST["email1"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
				$login_email = test_input($_POST["email1"]);
			}
			
			if ( empty($_POST["password1"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				
				if(strlen($_POST["password1"]) < 8) { 
				
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$login_password = test_input($_POST["password1"]);
				}
				
			}
			
			if($email_error == "" && $password_error ==""){
				
				echo "kontrollin sisselogimist ".$login_email." ja parool ";
			}
		
		
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$login_email." ja parool on ".$login_password;
				
				$hash = hash("sha512", $login_password);
				
				echo $hash;
				
				loginUser($login_email, $hash);
			}
		}
		
		elseif(isset($_POST["create"])){
			
			echo "vajutas create nuppu!";
			
			//valideerimine create user vormile
			//kontrollin et e-post ei ole tühi
			if ( empty($_POST["First_name"]) ) {
				$first_name_error = "See väli on kohustuslik";
			}else{
				$First_name= test_input($_POST["First_name"]);
			}
			
			if ( empty($_POST["Last_name"]) ) {
				$last_name_error = "See väli on kohustuslik";
			}else{
				$Last_name = test_input($_POST["Last_name"]);
			}
			
			if ( empty($_POST["email_add"]) ) {
				$email_add_error = "See väli on kohustuslik";
			}else{
				
				$email_add = test_input($_POST["email_add"]);
			}
			
			if ( empty($_POST["email_confirm"]) ) {
				$email_confirm_error = "See väli on kojustuslik";
			}else{
				$email_confirm = test_input($_POST["email_confirm"]);
			}
			
			if ( empty($_POST["password_one"]) ) {
				$password_one_error = "See väli on kohustuslik";
			} else {
				
				if(strlen($_POST["password_one"]) < 8) { 
				
					$password_one_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$password_one = test_input($_POST["password_one"]);
				}
			}
				
			if ( empty($_POST["password_confirm"]) ) {
				$password_confirm_error = "See väli on kohustuslik";
			}else {
				
				if(strlen($_POST["password_confirm"]) < 8) { 
				
					$password_confirm_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$password_confirm = test_input($_POST["password_confirm"]);
				}
			}
				if(	$email_add_error == "" && $password_one_error == ""){
					
				$hash = hash("sha512", $password_one);
				
				echo "Võib kasutajat luua! Kasutajanimi on ".$email_add." ja parool on ".$password_one. " ja räsi on".$hash;
				
				createUser($email_add, $hash, $First_name, $Last_name);
		  }
		}
		
		
		
	}
	// eemaldab tahapahtlikud osad
	function test_input($data) {
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 return $data;
	}
	
?>
<html>
<head>
	<title>Login page</title>
</head>
<body>
	<h2>Log in</h2>
	<form action="login.php" method="POST" >
		<input name="email" type="email" placeholder="E-post"> <?php echo $email_error; ?><br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?> <br><br>
		<input name="login" type="submit" value="Log in">
		
	</form>
	
	<h2>Create user</h2>
	<form action="login.php" method="POST" >
		<input name="First_name" type="name" placeholder="First name"> <?php echo $first_name_error; ?> <br><br>
		<input name="Last_name" type="name" placeholder="Last name"> <?php echo $last_name_error; ?> <br><br>
		<input name="email_add" type="email" placeholder="Email"> <?php echo $email_add_error; ?> <br><br>
		<input name="email_confirm" type="email" placeholder="Re-enter Email"> <?php echo $email_confirm_error; ?> <br><br>
				<?php
				echo "<select name='sel_date'>";
				$i = 1;
				while ($i <= 31) {
					echo "<option value='" . $i . "'>$i</option>";
					$i++;
				}
				echo "</select>";

				echo "<select name='sel_month'>";
				$month = array(
					"Jan",
					"Feb",
					"Mar",
					"Apr",
					"May",
					"Jun",
					"Jul",
					"Aug",
					"Sep",
					"Oct",
					"Nov",
					"Dec"
				);
				foreach ($month as $m) {
					echo "<option value='" . $m . "'>$m</option>";
				}
				echo "</select>";
				echo "<select name='sel_year'>";
				$j = 1920;
				while ($j <= 2015) {
					echo "<option value='" . $j . "'>$j</option>";
					$j++;
				}
				echo "</select>" ;
				?> <br><br>
		<input name="password_one" type="password" placeholder="Password"> <?php echo $password_one_error; ?> <br><br>
		<input name="password_confirm" type="password" placeholder="Re-enter Password"> <?php echo $password_confirm_error; ?>  <br><br>
		<input name="create" type="submit" value="Create"><br>
		 
		 <form>
		 Minu idee on teha spordilehekülg jalgpalli meeskonnas Manchester United, kus ma lisan uudiseid meeskonnas, siis võib teha foorumi, kus userid võivad arutleda meeskonna mänge ja jalgpallureid ja teha enda
		 teemasid.
		 </form>

</body>

</html>
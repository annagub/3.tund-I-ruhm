<?php
	require ("../../config.php");
	// var_dump (empty)
	//var_dump ($_GET);
	//echo "<br>";
	//var_dump ($_POST);
	$signupemailerror = "";
	$signuppassworderror = "";
	$signupemail = "";
	$gender = "";
	$gendererror = "";
	//kas epost oli olemas
	if (isset($_POST["gender"])){
		if (empty ($_POST["gender"])){
			$gendererror = "See väli on tühi";
		}
	}
	if(isset ($_POST["signupemail"])){
		
		if (empty ($_POST["signupemail"])){
			
			// oli email, kuid see oli tühi
			$signupemailerror = "See väli on tühi";
		} else {
			// email on õige, salvestan väärtuse muutujasse
			$signupemail = $_POST["signupemail"];
			
		}
	}

	if(isset ($_POST["signuppassword"])){
		if (empty ($_POST["signuppassword"])){
			$signuppassworderror = "See väli on tühi";
		} else {
			//tean et oli parool ja ei olnud tühi.
			//vähemalt 8
			if (strlen($_POST["signuppassword"]) < 8) {
				$signuppassworderror = "Parool peab olema vähemalt 8 tähemärkki pikk";
			}
			
		}
		
		
	}
	// Tean et ühtegi viga ei olnud ja saan kasutaja anmed salvestada
	if (isset($_POST["signuppassword"])&&
		isset ($_POST["signupemail"])&&
		empty ($signupemailerror)&& 
		empty ($signuppassworderror))
		{
		
		echo "Salvestan...<br>";
		echo "email".$signupemail. "<br>";
		
		$password = hash ("sha512", $_POST["signuppassword"]);
		
		echo "parool".$_POST["signuppassword"]."<br>";
		echo "räsi".$password."<br>";
		
		//echo $serverUsername;
		//echo $serverPassword;
		//ühedus
		$database = "if16_anna";
		$mysqli = new mysqli ($serverHost, $serverUsername, $serverPassword, $database);
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		//asendan ?,? väärtustega
		//iga muutuja kohta 1 täht, mis tüüpi muutuja on
		//s - string
		//i - integer
		//d - double/float
		$stmt->bind_param("ss", $signupemail, $password);
		if ($stmt->execute()){
			echo "salvestamine õnnestus";
		}else {
			echo "ERROR".$stmt->error;
		
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<form method = "POST">
			<!--<label>E-post</label><br>-->
			<input name="loginemail" placeholder="E-post">
			<br><br>
			<input name="loginpassword" placeholder="Parool">
			<br><br>
			<input type="submit" value="Logi sisse">
		</form>

	</body>
</html>

<h1>Loo kasutaja</h1>
		<form method = "POST">
			<!--<label>E-post</label><br>-->
			<input name="signupemail" type = "email" placeholder="E-post" value ="<?php echo $signupemail; ?>"> <?php echo $signupemailerror; ?>
			<br><br>
			<input name="signuppassword" type="password" placeholder="Parool"><?php echo $signuppassworderror; ?>
			<br><br>
			<?php echo $gendererror; ?>
			<?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Male<br>
			 <?php } ?>
			
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<p>
			 <?php } ?> 
			 
			<input type="submit" value="Logi sisse">
		</form>
		
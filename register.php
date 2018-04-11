<?php
	include ("includes/config.php");
	include ("includes/classes/Account.php");
	include ("includes/classes/Constants.php");
	$account=new Account($con);

	include ("includes/handlers/register-handler.php");
	include ("includes/handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Slotify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php
		if(isset($_POST['registerButton'])){
			echo '<script>
		$(document).ready(function(){

			$("#loginForm").hide();
			$("#registerForm").show(); 
		});
	</script>' ;
		}else{
			echo '<script>
		$(document).ready(function(){

			$("#loginForm").show();
			$("#registerForm").hide(); 
		});
	</script>';
		}
	?>
	
	<div id="background"> 
	<div id="loginContainer">
		
	
		<div id="inputContainer">
			<form id="loginForm" action="register.php" method="POST">
				<h2>Login to your account</h2>
				<p>
					<?php echo $account->getError(Constants::$loginFailed); ?>
					<label for="loginUsername">Username: </label>
					<input  id="loginUsername" type="text" name="loginUsername" placeholder="e.g. bartSimpson" value="<?php getInputValue('loginUsername') ?>"  required>
				</p>
				<p>
					<label for="loginPassword">Password : </label>
					<input id="loginPasssword" type="password" name="loginPassword"  placeholder="your password" required>
				</p>
				<button type="submit" name="loginButton">Login</button>
				<div class ="hasAccountText">
					<span id="hideLogin">Don't have an account yet? Signup here.</span>
				</div>
			</form>

			<form id="registerForm" action="register.php" method="POST">
				<h2>Create your free account</h2>
				<p>
					<?php echo $account->getError(Constants::$usernameCharacters); ?>
					<label for="username">Username: </label>
					<input value="<?php getInputValue('username') ?>" id="username" type="text" name="username" placeholder="e.g. bartSimpson" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$firstNameCharacters); ?>
					<label for="firstName">First Name: </label>
					<input value="<?php getInputValue('firstName') ?>"  id="firstName" type="text" name="firstName" placeholder="e.g. Bart" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$lastNameCharacters); ?>
					<label for="lastName">Last name : </label>
					<input value="<?php getInputValue('lastName') ?>"  id="lastName" type="text" name="lastName" placeholder="e.g. Simpson" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
					<?php echo $account->getError(Constants::$emailInvalid); ?>
					<label for="email">Email: </label>
					<input value="<?php getInputValue('email') ?>"  id="email" type="email" name="email" placeholder="e.g. bart@gmail.com" required>
				</p>
				<p>
					<label for="email2">Confirm email: </label>
					<input value="<?php getInputValue('email2') ?>"  id="email2" type="email" name="email2" placeholder="e.g. bart@gmail.com" required>
				</p>

				<p>
					<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
					<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
					<?php echo $account->getError(Constants::$passwordCharacters); ?>
					<label for="password">Password : </label>
					<input id="password" type="password" name="password" placeholder="your password"  required>
				</p>
				<p>
					<label for="password2">Password : </label>
					<input id="password2" type="password" name="password2"  placeholder="your password" required>
				</p>
				<button type="submit" name="registerButton">SIGN UP</button>

				<div class="hasAccountText">
					<span id="hideRegister">Already have an account? Log In here.</span>
				</div>
			</form>
		</div>
		<div id="loginText">
			<h1>Get great music, right now</h1>
			<h2>Listen to loads of songs for free</h2>
			<ul>
				<li>
Discover music you'll fall in love with</li>
				<li>Create your own playlistss</li>
				<li>Follow artists to keep up to date</li>
			</ul>
		</div>
	</div>
</div>
</body> 
</html>
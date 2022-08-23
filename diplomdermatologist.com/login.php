<?php
session_start();
	// Check if the user is already logged in, if yes then redirect him to welcome page
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
			header("location: welcome.php");
			exit;
			}
			// Include config file
			require_once "config.php";
			// Define variables and initialize with empty values

			$username = $password = "";
			$username_err = $password_err = "";
			
			// Processing form data when form is submitted
			if($_SERVER["REQUEST_METHOD"] == "POST"){
			// Check if username is empty
			if(empty(trim($_POST["username"]))){
			$username_err = "Будь ласка введіть никнейм.";
			} else{
			$username = trim($_POST["username"]);
			}
			// Check if password is empty
			if(empty(trim($_POST["password"]))){
			$password_err = "Будь ласка введіть пароль.";
			} else{
			$password = trim($_POST["password"]);
			}
			// Validate credentials
			if(empty($username_err) && empty($password_err)){
			// Prepare a select statement
			$sql = "SELECT id, username, password FROM users WHERE username = ?";
			if($stmt = mysqli_prepare($link, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			// Set parameters
			$param_username = $username;
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
			// Store result
			mysqli_stmt_store_result($stmt);
			// Check if username exists, if yes then verify password
			if(mysqli_stmt_num_rows($stmt) == 1){                    
			// Bind result variables
			mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
			if(mysqli_stmt_fetch($stmt)){
			if(password_verify($password, $hashed_password)){
			// Password is correct, so start a new session
			session_start();
			// Store data in session variables
			$_SESSION["loggedin"] = true;
			$_SESSION["id"] = $id;
			$_SESSION["username"] = $username;                            
			// Redirect user to welcome page
			header("location: welcome.php");
			exit;
			} else{
			// Display an error message if password is not valid
			$password_err = "Пароль введен невірний.";
			}
			}
			} else{
			// Display an error message if username doesn't exist
			$username_err = "Не знайдено акаунту з таким ім'ям.";
			}
			} else{
			echo "Упс! Щось сталось. Будь ласка, спробуйте ще раз, пізніше.";
			}
			// Close statement
			mysqli_stmt_close($stmt);
			}
			} 
			// Close connection
			mysqli_close($link);
			}
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="img/logo.png">
		<meta name="author">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta charset="UTF-8">
		<title>Реєстрація</title>
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/jquery-ui.css">				
			<link rel="stylesheet" href="css/nice-select.css">							
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">				
			<link rel="stylesheet" href="css/main.css">
			<style>
			.wrapper{
				margin: 0 auto;
				width: 450px;
				height: 420px;
			}
			</style>
</head>
<body>
	<!--header id="header">
		<div class="container">
		   	<div class="row fullscreen align-items-center justify-content-between">
				<div id="logo">
			      <a href="index.php"><img src="img/logo.png" alt="" title="" /></a>
			      </div>
			      <nav id="nav-menu-container">
			        <ul class="nav-menu">
			          <li><a href="index.php">Головна</a></li>
			          <li class="menu-has-children"><a href="about.html">Про нас</a>
						<ul>
			              <li><a href="#">Рівень 2</a></li>
			            </ul> 
					  </li>
			          <li class="menu-has-children"><a href="services.html">Послуги</a>
						<ul>
			              <li><a href="#">Рівень 2</a></li>
			            </ul>
					  </li>
			          <li class="menu-has-children"><a href="price.html">Прайс-лист</a>
						<ul>
			              <li><a href="#">Рівень 2</a></li>
			            </ul>					  
					  </li>	          		          
			          <li class="menu-has-children"><a href="contact.html">Контакти</a>
						<ul>
			              <li><a href="#">Рівень 2</a></li>
			            </ul>
					  </li>
					 <li><a href="register.php">Вхід та реєстрація</a></li>
					</ul>
				   </nav>		    		
			</div>
		</div>
</header-->
    <div class="col-lg-61 col-md-6 banner-left forh3header "><h3>Вхід на сайт</h3></div>
	<div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
<!-- start footer Area -->
            <footer class="footer-area section-gap">
					<div class="container">
						<div class="row">
							<div class="col-lg-5 col-md-6 col-sm-6">
								<div class="single-footer-widget">
								<h4>Персональний сайт Анастасії Кондратюк</h4>
									<p class="footer-text">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved 
									<i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://google.com" target="_blank">Google</a></p>
								</div>
							</div>
							<div class="col-lg-5 col-md-6 col-sm-6">
                            <div class="single-footer-widget">
                                <h4>Безкоштовна консультація </h4>
                                <p>Не зволікайте пишіть нам!</p> 
								<div id="mc_embed_signup">
									 <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get">
									  <div class="input-group">
									    <input type="text" class="form-control" name="EMAIL" placeholder="Введіть сюди свою пошту" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email Address '" required="" type="email">
									    <div class="input-group-btn">
									      <button class="btn btn-default" type="submit">
									        <span class="lnr lnr-arrow-right"></span>
									      </button>    
									    </div>
									    	<div class="info"></div>  
									  </div>
									</form> 
								</div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 social-widget">
                            <div class="single-footer-widget">
                                <h4>Підписуйтеся на мене</h4>
                                <p>Беріть участь у соціальному житті!</p>
                                <div class="footer-social d-flex align-items-center">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
<!-- End footer Area -->
			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="js/popper.min.js"></script>
			<script src="js/vendor/bootstrap.min.js"></script>			
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>			
  			<script src="js/easing.min.js"></script>			
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>	
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>	
    		<script src="js/jquery.tabs.min.js"></script>						
			<script src="js/jquery.nice-select.min.js"></script>	
            <script src="js/isotope.pkgd.min.js"></script>			
			<script src="js/waypoints.min.js"></script>
			<script src="js/jquery.counterup.min.js"></script>
			<script src="js/simple-skillbar.js"></script>							
			<script src="js/owl.carousel.min.js"></script>							
			<script src="js/mail-script.js"></script>	
			<script src="js/main.js"></script>
	</body>
</html>
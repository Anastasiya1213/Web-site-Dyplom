<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
		<title>Welcome</title>
		<style>
		h3	{
			padding-bottom: 50px;
		}
		iframe {
			width: 60%;
			height: 1000px;
			padding-bottom: 100px;
		}
		</style>
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
			<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header id="header">
		<div class="container">
		   	<div class="row fullscreen align-items-center justify-content-between">
				<div id="logo">
			      <a href="index.php"><img src="img/logo.png" alt="" title="" /></a>
			      </div>
			      <nav id="nav-menu-container">
			        <ul class="nav-menu">
			          <li><a href="index.php">Головна</a></li>
			         <li class="menu-has-children"><a href="about.html">Про нас</a></li>
			          <li class="menu-has-children"><a href="services.html">Послуги</a>
						<ul>
			              <li>Дерматологія</li>
						  <li><a href="#">Профілактика шкірних захворювань</a></li>
						  <li><a href="#">Профілактика захворювань які передаються статевим шляхом</a></li>
						  <li><a href="#">Лікування псоріазу</a></li>
						  <li><a href="#">Лікування екземи</a></li>
			            </ul>
					  </li>
			          <li class="menu-has-children"><a href="price.html">Прайс-лист</a></li>	          		          
			          <li class="menu-has-children"><a href="contact.html">Контакти</a>
					  <li><a href="">Мій кабінет</a></li>
					  <li><a href="logout.php">Вихід</a></li>
					</ul>
				   </nav>		    		
			</div>
		</div>
</header>
<!-- start banner Area -->
		<section class="relative about-banner">	
			<div class="overlay overlay-bg"></div>
			<div class="container">				
				<div class="row d-flex align-items-center justify-content-center">
					<div class="about-content col-lg-12">
						<h1 class="text-white">
							Акаунт пацієнта				
						</h1>	
						<p class="text-white link-nav"><a href="index.php">Головна</a><span class="lnr lnr-arrow-right"></span>
						<a href="welcome.php"> Акаунт пацієнта</a></p>
					</div>	
				</div>
			</div>
		</section>
<!-- End banner Area -->		
<div class="col-lg-61 col-md-6 banner-left forh3header"><h3><br>Ласкаво прошу, <b><?php echo htmlspecialchars($_SESSION["username"]);?></b> !</h3></div>
<div class="file-upload">
	<form action="welcome.php" method="post" enctype="multipart/form-data">	
		<div class="form-group">
			<label for="myfile" class="chous">Выберите файлы</label>
			<input type="file" class="my" id="myfile" name="myfile" multiple="multiple"><br>	
		</div>
		<button class="btn btn-primary" type="submit" name="save">Завантажити</button>
	</form>		
</div>
 		<p><a href="reset-password.php" class="btn">Змінити мій пароль</a></p>
		<section>

		<?php
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			$conn = mysqli_connect('localhost', 'root', '', 'mydb');
			$sql = "SELECT * FROM medcards";
			$result = mysqli_query($conn, $sql);
			$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
			if (isset($_POST['save'])) {
			$filename = $_FILES['myfile']['name'];
			$destination = 'img/'. $filename;
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$file = $_FILES['myfile']['tmp_name'];
			$size = $_FILES['myfile']['size'];
				if (!in_array($extension, ['pdf', 'png', 'jpg'])) {
				echo "You file extension must be .jpg, .pdf or .png";
			} else if ($_FILES['myfile']['size'] > 1000000000) {
				echo "File too large!";
			} else {	
				if (move_uploaded_file($file, $destination)) {
					$sql = "INSERT INTO medcards (name, size) VALUES ('$filename', $size)";
					if (mysqli_query($conn, $sql)) { ?>
				<center><iframe src="<?php echo $destination; ?>" ></iframe></center>
				<?php
					}
				} else {
					echo "Failed to upload file.";
				}
			} 
		}?>
		</section>
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
			<script src="js/selectfiles.js"></script>
	</body>
</html>
<?php
// Инициализировать сессию
session_start();
 
// Проверьте, вошел ли пользователь в систему, иначе перенаправьте на страницу входа.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
require_once "config.php";
 
// Определите переменные и инициализируйте пустыми значениями
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Обработка данных формы при отправке формы
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Подтвердите новый пароль
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Подтвердить подтверждение пароля
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Проверьте ошибки ввода перед обновлением базы данных
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Подготовьте заявление об обновлении
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Привязать переменные к подготовленному выражению в качестве параметров
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            // Установить параметры
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            // Попытка выполнить подготовленное заявление
            if(mysqli_stmt_execute($stmt)){
                // Пароль успешно обновлен. Уничтожить сеанс и перенаправить на страницу входа
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Упс! Щось сталось. Будь ласка, спробуйте ще раз, пізніше.";
            }

            // Закрытие сессии
            mysqli_stmt_close($stmt);
        }
    }
    // Закрытие соединения
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
		<title>Reset Password</title>

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
			.wrapper {
				margin: 0 auto;
				width: 450px;
				height:	420px;
			}
			</style>
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
</header>
		


<div class="col-lg-61 col-md-6 banner-left forh3header"><h3>Відновити пароль</h3></div>
	<section class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
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
</body>
</html>
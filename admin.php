<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

$x=rand(1,9999);
$g = new Gallery();

$step=1;
$deleteMessage='';

// determine page number and totals for pagination
if(isset($_GET['page'])){ $page = intval($_GET['page']); }
else { $page = 1; }
$totalGalleries = $g->getTotalGalleries();
$totalPages = ceil( $totalGalleries / RESULTS_PERPAGE ); 


// logging in
if(isset($_POST['loginForm'])){
	if($g->doLogin($_POST)){
		$step=2;
		setcookie('photoLogged','y');
	}
	else {
		$error = '<p class="error">Incorrect email/password. Please try again.</p>';
	}
}


// deleting gallery
if(isset($_POST['deleteGallery'])){
	if($g->deleteGallery($_POST['id'])){
		$deleteMessage = '<p class="success">Gallery successfully deleted.</p>'; 
	}
}


// update gallery
if(isset($_POST['updateGallery'])){
	if($g->updateGallery($_POST)){
		$deleteMessage = '<p class="success">Gallery successfully updated</p>'; 
	}
}


// add slide
if(isset($_POST['addSlide'])){
	echo 'HELLO GOVNER';
}


// add gallery
if(isset($_POST['addGallery'])){
	if($g->addGallery($_POST)){
		$deleteMessage = '<p class="success">Gallery successfully created.</p>'; 
	}
}


// bypass login form if cookie set
if(isset($_COOKIE['photoLogged']) && $_COOKIE['photoLogged']=='y'){ $step=2; }

// get galleries
if($step==2){ $adminHTML = $g->getAdminListing($page); }


if($_SERVER['HTTP_HOST']=='localhost'){ 

	// local header - comment out to go live on cc server

	include(ROOT_PATH . 'inc/header-local.inc.php');

} else {

	// cc header - remove comment tags to go live on cc servers

	//set variables for og tags and other meta data
	$page_title = $gallery['title'];
	$page_description = "Check out the latest gallery";
	$keywords = "gallery,instagram,vine,twitter";
	$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

	$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
	include('CCOMRheader.template'); // do not modify this line
}
?>

	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/jquery.fancybox.css?x=<?php echo $x; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/flexslider.css?x=<?php echo $x; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css?x=<?php echo $x; ?>">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/font-awesome.min.css?x=<?php echo $x; ?>">


	<div class="pageContainer">

		<img src="img/header.jpg?" class="header" />

		<?php if($step==1){ ?>

			<!-- search form -->
			<form action="" method="post" id="theForm">
				<?php if(isset($error)){ echo $error; } ?>
				<input type="hidden" name="loginForm" value="y" />
				<p><label>Your Email Address:</label><input type="email" class="required" name="email" placeholder="Your Email" value="<?php echo @$_POST['email']; ?>" /></p>
				<p><label>Password:</label><input type="password" class="required" name="pword" value="<?php echo @$_POST['pword']; ?>" /></p>
				<p><input type="submit" name="submit" value="Log In" /></p>
			</form>

		<?php } ?>

		<?php if($step==2){ ?>

			<div class="logoutbox clearfix"><a href="logout.php">Sign Out</a></div>
			<div class="clearfix">&nbsp;</div>

			<?php
			echo $deleteMessage; ?>
			<?php include(ROOT_PATH . 'inc/pagination.html.php'); ?>
			<?php echo $adminHTML['table'];
			echo $adminHTML['hidden']; ?>
			<?php include(ROOT_PATH . 'inc/pagination.html.php'); ?>

		<?php } ?>

	</div>

	<script src="<?php echo BASE_URL; ?>js/jquery-1.10.1.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.flexslider-min.js?"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.fancybox.pack.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script>
		$(document).ready(function() {
				
			$('.fancybox').fancybox();
			

				
			<?php if(isset($_POST['addSlide'])){ ?>
				$("a.addslide").trigger('click'); 
			<?php } ?>

		    // add a slide to gallery - step 1
		    $("a.addslide").click(function(event){
		    	// get gallery values to populate form
		    	var galleryTitle = $(this).attr('gallery-title');
		    	var galleryID = $(this).attr('gallery-id');
				
				// write form
				//$('#add-slide-box').html('<h2>Add Slide to Gallery</h2><h3 id="gallery-title">'+galleryTitle+'</h3><div id="addslide-topcontent"><form><input type="hidden" name="addSlide" value="y" /><input type="hidden" name="gallery-id" id="gallery-id" value="'+galleryID+'" /><p><label>Embed Code</label><textarea class="codeholder" name="code"></textarea></p><p><label>Description Text</label><textarea class="codeholder" name="description"></textarea></p><p><label></label><input type="submit" class="button" id="submit-slide" value="Add Slide"/></p></form><p><a id="add_paragraph" class="button button-blue" href="javascript:;" title="Add">Add new paragraph</a></div><div id="addslide-bottomcontent"></div>');
				$('#add-slide-box').html('<p><a id="add_paragraph" class="button button-blue" href="javascript:;" title="Add">Add new paragraph</a></p>');
				
			});

			$("#add_paragraph").click(function() {
				$(this).parent().next().clone().appendTo( $(this).parent() );
				$.fancybox.update();
			});


		});

			
	
	</script>

<?php if($_SERVER['HTTP_HOST']=='localhost'){ 

	// local footer - comment out to go live on cc servers
	include(ROOT_PATH . 'inc/footer-local.inc.php');

} else {

	//cc footer - remove comment tags to go live on cc servers
	include('CCOMRfooter.template');

} ?>

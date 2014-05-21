<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

$x=rand(1,9999);
$g = new Gallery();

$step=1;
$addMessage='';

// add slide
if(isset($_POST['addGallery']) && $_POST['addGallery']=='y'){
	$g->addGallery($_POST);
	$step=2;
	$addMessage = '<p class="success">Gallery <strong>"' . stripslashes(trim($_POST['title'])) . '"</strong> added. Add more below or <a href="admin.php?'.$x.'">GO BACK TO MAIN PAGE.</a></p>';
}


// bypass login form if cookie set
if(!isset($_COOKIE['photoLogged']) || $_COOKIE['photoLogged']!='y'){ header("Location: admin.php"); }


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
			
			
			<form action="" method="post" id="theForm">
				<h2>Add a Gallery</h2>
				<?php echo $addMessage; ?>
				<input type="hidden" name="addGallery" value="y" />
				<p><label>Gallery Title</label><input type="text" name="title" class="required" /></p>
				<p><label>Gallery Description</label><textarea name="description" class="codeholder required"></textarea></p>
				<p><input type="submit" class="button" value="Add Gallery" /></p>
			</form>
			<p>&nbsp;</p>
			<p>&nbsp;</p>


	</div>

	<script src="<?php echo BASE_URL; ?>js/jquery-1.10.1.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.flexslider-min.js?"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.fancybox.pack.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script>
		$(document).ready(function() {
				

		});

	</script>

<?php if($_SERVER['HTTP_HOST']=='localhost'){ 

	// local footer - comment out to go live on cc servers
	include(ROOT_PATH . 'inc/footer-local.inc.php');

} else {

	//cc footer - remove comment tags to go live on cc servers
	include('CCOMRfooter.template');

} ?>

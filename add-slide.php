<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

$x=rand(1,9999);
$g = new Gallery();

$step=1;
$addMessage = '<p class="success"><a href="admin.php?x='.$x.'">GO BACK TO MAIN PAGE.</a></p>';
$adeleteMessage='';
$slideDeletedMessage='';

$galleryName = $g->galleryName($_GET['id']);


// add slide
if(isset($_POST['addSlide']) && $_POST['addSlide']=='y'){
	$lastSlideID = $g->addSlide($_POST);
	$step=2;
	$addMessage = '<p class="success">Slide Added. Add more below or <a href="admin.php?x='.$x.'">GO BACK TO MAIN PAGE.</a></p>';
	}

// deleting gallery
if(isset($_GET['d'])){
	if($g->deleteSlide($_GET['d'])){
		$slideDeletedMessage =  '<p class="success">Slide successfully deleted.</p>'; 
	}
}


// get info on most recent slide
$lastSlide = $g->getLastSlide($_GET['id']);
if($lastSlide!==false){
	$lastSlideMessage = $slideDeletedMessage.'<p class="slideholder" style="margin-right:0important;"><strong>Last slide added:</strong><br />' . $lastSlide['description'] . '<br />' . $lastSlide['code'] . '<br />Slide error? <a href="add-slide.php?id='.$_GET['id'].'&d='.$lastSlide['id'].'">DELETE THIS SLIDE</a></p>';
}
else {
	$lastSlideMessage = $slideDeletedMessage.'<p class="slideholder" style="margin-right:0important;"><strong>No slides currently in gallery.</strong></p>';
}

// bypass login form if cookie set
if(!isset($_COOKIE['photoLogged']) || $_COOKIE['photoLogged']!='y'){ header("Location: admin.php"); }

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
			
			
			<form action="" method="post" id="theForm" class="leftForm" style="height:860px;">
				<h2><?php echo $galleryName; ?></h2>
				<h3 class="textleft">Add Slides</h3>
				<?php echo $addMessage; ?>
				<input type="hidden" name="addSlide" value="y" />
				<input type="hidden" name="gallery_id" value="<?php echo $_GET['id']; ?>" />
				<p><label>Embed Code</label><textarea name="code" class="codeholder w-100 required"></textarea></p>
				<p><label>Description</label><textarea name="description" class="codeholder w-100 required"></textarea></p>
				<p><input type="submit" class="button" value="Add Slide" /></p>
			</form>

			<?php echo $lastSlideMessage; ?>
			<div class="clear"></div>



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

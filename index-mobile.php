<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 



$x=rand(1,9999);

$url = array();
foreach($_GET as $key=>$value){
	$url[] = $key;
}
$urlCode = $url[0];

$g = new Gallery($urlCode);


// get gallery details
$gallery = $g->getGallery();

if($gallery['thumb_url']==''){ $gallery['thumb_url'] = 'http://www.1047kissfm.com/cc-common/gallery/thumb.php?src=/export/home/cc-common/mlib/1096/05/1096_1401292437.jpg'; }

$fbShare = $g->fbShare(urlencode($gallery['title']), $urlCode, $gallery['thumb_url']);


// get slides in gallery
$slides = $g->getSlides($gallery['id']);
$recentGalleries = $g->getRecentGalleries($gallery['id']);


//if($galleryHTML===false){ $galleryHTML = '<h2>Sorry, there were no results found for "' . $_POST['searchStr'] . '"</h2><p><a href="index.php">safsdfsafsafdsafsdfsdfsadfsafsdafsdfafsadfsafsdfsafsafdsiew Recent Galleries</a> or use the box to search again.</p>'; }

if($_SERVER['HTTP_HOST']=='localhost'){ 

	// local header - comment out to go live on cc server

	include(ROOT_PATH . 'inc/header-local.inc.php');

} else {

	// cc header - remove comment tags to go live on cc servers

	//set variables for og tags and other meta data
	$page_title = $gallery['title'];
	$page_description = $gallery['title'];
	$keywords = "gallery,instagram,vine,twitter";
	$url = "http://" . $_SERVER["HTTP_HOST"] .$PHP_SELF; // do not modify this line

	//$useT27Header = true; //this is a global flag that controls the header file that will be included. Do not change or remove this variable.
	//include('CCOMRheader.template'); // do not modify this line
}
?>



<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title><?php echo $stationName; ?> Photos: <?php echo $gallery['title']; ?></title>

<script src="js/vendor/custom.modernizr.js?x=<?php echo $x; ?>"></script>
<link rel="stylesheet" href="css/foundation.css?x=<?php echo $x; ?>" />
<link href='http://fonts.googleapis.com/css?family=Patua+One|Gudea:400,700,400italic|Medula+One|Oxygen|Anaheim|Racing+Sans+One' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/style.css?x=<?php echo $x; ?>" />

<link rel="stylesheet" href="css/flexslider.css?x=<?php echo $x; ?>">
<link rel="stylesheet" href="css/mobile.css?x=<?php echo $x; ?>" />
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/font-awesome.min.css?x=<?php echo $x; ?>">
  <script src="js/vendor/jquery.js?"></script>
  <script src="js/jquery.flexslider-min.js?"></script>
<script>

	$(document).ready(function() {


			var index = 0, hash = window.location.hash;
			if (hash) {
		        index = /\d+/.exec(hash)[0];
		        index = (parseInt(index) || 1) - 1;
		    }

			$('.flexslider').flexslider({
		        startAt: index,
		        slideshow: false,
		        video:true,
		        smoothHeight:true,
		        start: function(slider){
		          $('body').removeClass('loading');
		        }

		      });

			var adRatio;
			adRatio=1;
			var alt; 

			// track pageviews / change ads
			$('.flex-next').click(function(event){
				if(adRatio===4) { adRatio = 1; }

				if(alt){ alt = ''; }
		        else { alt = '-alt'; }

		        viewframe.location.href='view'+alt+'.php?g=<?php echo $urlCode; ?>';
		        if(adRatio===1) { adframe.location.href='ad.php?1'; }
		        
		        adRatio = adRatio+1;
		         
		    });

		    $('.flex-prev').click(function(event){
		        if(adRatio===4) { adRatio = 1; }
	
		        if(alt){ alt = ''; }
		        else { alt = '-alt'; }

		        viewframe.location.href='view'+alt+'.php?g=<?php echo $urlCode; ?>';
		        if(adRatio===1) { adframe.location.href='ad.php?2'; }
		        
		        adRatio = adRatio+1;
		        
		    });

		});



	</script>
</head>

<body class="live">

	<div class="header-bar">
		<img src="img/iheart_header.svg" />
		<nav class="top-bar">
			<ul class="title-area">
				<li class="name"></li>
				<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
			</ul>

			<section class="top-bar-section">
				<ul class="right">
			      <li class="divider"></li>
			      <li class="active"><a href="/photos/">Photos</a></li>
			      <li class="divider"></li>
			      <li class="active"><a href="http://www.iheart.com/live/<?php echo $iheartID; ?>/?autoplay=true">Listen Live</a></li>
			      <li class="divider"></li>
			      <li class="active"><a href="/articles/">News</a></li>
			      <li class="divider"></li>
			      <li class="active"><a href="/cc-common/contests/">Contests</a></li>
			      <li class="divider"></li>
			   </ul>
			</section>

		</nav>
	</div>

	<div class="subheader">
		
		<div id="logo-mobile"><img src="img/<?php echo $shortName; ?>.png" /></div>

		<ul class="subhead">
			<li class=""><img src="img/icon-connect.png" /><a href="#">Connect</a></li>
			<li class="norm"><img src="img/icon-listen.png" /><a href="http://www.iheart.com/live/<?php echo $iheartID; ?>/?autoplay=true">Listen</a></li>
		</ul>

		<div class="clear"></div>
			
	</div>


	<!-- main content area -->
	<div class="row">

		<div class="large-12 columns">
    	
	    	<h2><?php echo $gallery['title']; ?></h2>
	    	<p><?php echo $gallery['description']; ?></p>
    	

			<!-- gallery -->
	    	<div class="flexslider carousel">
				<ul class="slides">

					<?php foreach ($slides as $slide){
						echo '<li>' . $slide['code'] . '<p>' . $slide['description'] . '</p></li>'."\n";
					}
					?>

				</ul>
			</div>

    	</div>

    	

    	<!-- share box -->
		<div class="mobilesharebox">
			<h4>SHARE THIS PAGE</h4>
			<div class="thirdcol"><a class="mobileshare left" href="<?php echo 'https://www.facebook.com/dialog/feed?app_id=' . $fbAppID . '&link='.$_SERVER['SCRIPT_URI'].'?'.$_SERVER['QUERY_STRING'].'&picture=http://'.$_SERVER['HTTP_HOST'].'/common/live/artist-images/' . $artistUrlCode . '.jpg&name=' . $gallery['title'] . 'Photos on ' . $stationName . '&caption=Photo+Gallery&description=Check+Out+These+Photos&redirect_uri=http://'.$_SERVER['HTTP_HOST']; ?>" target="_blank"><img src="img/icon-facebook-color.jpg" /></a></div>
			<div class="thirdcol"><a class="mobileshare center" href="http://twitter.com/share?text=Check out this sweet gallery I found:%20<?php echo $gallery['title']; ?>&url=http://<?php echo $_SERVER['HTTP_HOST']; ?>/common/gallery/?<?php echo $gallery['url_code']; ?>" target="_blank"><img src="img/icon-twitter-color.jpg" /></a></div>
			<div class="thirdcol"><a class="mobileshare right" href="https://plus.google.com/share?url=<?php echo $_SERVER['SCRIPT_URI'].'?'.$_SERVER['QUERY_STRING']; ?>" target="_blank"><img src="img/icon-google-color.jpg" /></a></div>
			<div class="clear"></div>
		</div>

    	<iframe name="viewframe" width="1" height="1" src="view.php?g=<?php echo $urlCode; ?>" frameborder="0" scrolling="no" ></iframe>
    

	</div>

	<!-- footer links -->
	<ul class="mobile-footer">
		<li><a href="/photos/"><img src="img/iheart_header.png" /></a></li>		
		<li><img src="img/cc_logo.png?"/></li>		
		<div class="clear"></div>
	</ul>


	<script>
	document.write('<script src=' +
	('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
	'.js><\/script>')
	</script>
  
  <script src="js/foundation.min.js?"></script>

  
	<script>
	
	$(document).foundation();

</script>


</body>
</html>
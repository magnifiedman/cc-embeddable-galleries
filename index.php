<?php 
require_once('lib/config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 



$x=rand(1,9999);

foreach($_GET as $key=>$value){ $urlCode = $key; }

$g = new Gallery($urlCode);


// get gallery details
$gallery = $g->getGallery();


// get slides in gallery
$slides = $g->getSlides($gallery['id']);
$recentGalleries = $g->getRecentGalleries($gallery['id']);


//if($galleryHTML===false){ $galleryHTML = '<h2>Sorry, there were no results found for "' . $_POST['searchStr'] . '"</h2><p><a href="index.php">View Recent Galleries</a> or use the box to search again.</p>'; }

if($_SERVER['HTTP_HOST']=='localhost'){ 

	// local header - comment out to go live on cc server

	include(ROOT_PATH . 'inc/header-local.inc.php');

} else {

	// cc header - remove comment tags to go live on cc servers

	//set variables for og tags and other meta data
	$page_title = $gallery['title'];
	$page_description = "Gallery - " . $gallery['title'];
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

		<!--Start Left Column-->
    	<div class="leftContainer">

    		<!-- <div id="counter">Counter</div> -->
    	
    	<h2><?php echo $gallery['title']; ?></h2>
    	<p><?php echo $gallery['description']; ?></p>
    	<h4>
    		<a href="http://www.facebook.com/sharer.php?u=http://<?php echo $_SERVER['HTTP_HOST']; ?>/common/gallery/?<?php echo $gallery['url_code']; ?>" target="_blank"><i class="fa fa-facebook-square"></i> Share on Facebook</a>
    		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://twitter.com/share?text=Check out this sweet gallery I found:%20<?php echo $gallery['title']; ?>&url=http://<?php echo $_SERVER['HTTP_HOST']; ?>/common/gallery/?<?php echo $gallery['url_code']; ?>" target="_blank"><i class="fa fa-twitter-square"></i> Share on Twitter</a>
    	</h4>

		<!-- gallery -->
    	<div class="flexslider carousel">
			<ul class="slides">

				<?php foreach ($slides as $slide){
					echo '<li>' . $slide['code'] . '<p>' . $slide['description'] . '</p></li>';
				}
				?>

			</ul>
		</div>

    	</div>

    	<!--Start Right Column-->
    	<div class="rightContainer">

			<!-- <div class="moduleContainer">
				<?php
				//include(COMMON_JS."share-email-bookmark.php"); // do not modify this line
				//include(COMMON_JS."facebooklike.php"); // do not modify this line
				?>
			</div> -->
			<div class="moduleContainer" id="ad300x250">
				<iframe name="adframe" width="300" height="250" src="ad.php?" frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
    		</div>

			<div class="moduleContainer">
				<div class="moduleTitle">Other Recent Galleries</div>
				<div class="moduleContentContainer">
					<ul class="moduleSubItems">
					    
					    <?php echo $recentGalleries; ?>

					</ul>
				</div>
			</div>

    	</div>

    	<div class="clear"></div>

    	<iframe name="viewframe" width="1" height="1" src="view.php?g=<?php echo $urlCode; ?>" frameborder="0" scrolling="no" ></iframe>
    

	</div>

	<!-- <script src="<?php echo BASE_URL; ?>js/jquery-1.10.1.min.js"></script> -->
	<script src="<?php echo BASE_URL; ?>js/jquery.flexslider-min.js?"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.validate.min.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.fancybox.pack.js"></script>
	<script src="<?php echo BASE_URL; ?>js/jquery.mousewheel-3.0.6.pack.js"></script>
	<script>
		$(document).ready(function() {
				
			$('.fancybox').fancybox();
			$('#previewpop').fancybox();
			$("#theForm").validate();

			$("a.preview").click(function(event){
				var gid = $(this).attr('id');
				$.ajax({
					type: "get",
					url: "lib/ajax.php",
					data: "id="+gid,
					dataType: 'html',
					success: function (data) {
						$('#preview').html(data);
						$('#previewpop').trigger('click'); 
					}
				});
			});

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

		        viewframe.location.href='view'+alt+'.php';
		        if(adRatio===1) { adframe.location.href='ad.php?1'; }
		        
		        adRatio = adRatio+1;
		         
		    });

		    $('.flex-prev').click(function(event){
		        if(adRatio===4) { adRatio = 1; }
	
		        if(alt){ alt = ''; }
		        else { alt = '-alt'; }

		        viewframe.location.href='view'+alt+'.php';
		        if(adRatio===1) { adframe.location.href='ad.php?2'; }
		        
		        adRatio = adRatio+1;
		        
		    });

		});

	
	</script>

	<script type="text/javascript" src="/cc-common/wss/hbx.js"></script><script type="text/javascript">
		<!-- 
		s.pageName="gallery:embeddable:<?php echo $urlCode; ?>"
		/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
		var s_code=s.t();if(s_code)document.write(s_code)
		//-->
	</script>

<?php if($_SERVER['HTTP_HOST']=='localhost'){ 

	// local footer - comment out to go live on cc servers
	include(ROOT_PATH . 'inc/footer-local.inc.php');

} else {

	//cc footer - remove comment tags to go live on cc servers
	include('CCOMRfooter.template');

} ?>

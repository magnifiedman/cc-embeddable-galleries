<?php
/* Embeddable Photo Galleries Class
 * Original Creation Date 05.2014
 * Wherein we create all functions for this application
 */


class Gallery {

	
	/**
	 * Sets url code
	 * @param string $urlCode
	 * @var string $urlCode
	 */
	function Gallery($urlCode) {
        $this->urlCode = $urlCode;
    }
	
	
	### FRONTEND FUNCTIONS ##########

    /**
     * Gets gallery details from urlCode
     * @return array
     */
	function getGallery(){
		$q = sprintf("SELECT *
			FROM " . GALLERIES_TABLE . "
			WHERE url_code = '%s'",
			mysql_real_escape_string($this->urlCode)
			);

		$r = mysql_query($q);
		return mysql_fetch_assoc($r);
	}


	/**
	 * Gets all slides in gallery
	 * @param  int $galleryID
	 * @return array
	 */
	function getSlides($galleryID){
		$q = mysql_query("SELECT *
		FROM " . SLIDES_TABLE . "
		WHERE gallery_id = '". $galleryID ."'");

		if(mysql_num_rows($q)>0){ 
			$slides = array();
			while ($slide = mysql_fetch_assoc($q)){
				$slides[] = $slide;
			}
			return $slides;
		}
	}


	/**
	 * Gets total galleries in system
	 * @return int count(id)
	 */
	function getTotalGalleries(){

		$r = mysql_query("
			SELECT count(id) 
			FROM " . GALLERIES_TABLE);
		if(mysql_num_rows($r)>0){ return mysql_result($r,0,'count(id)'); }
	}


	/**
	 * Returns gallery name
	 * @param  int $galleryID
	 * @return string Gallery Name
	 */
	function galleryName($galleryID){
		$r = mysql_query("
			SELECT title
			FROM " . GALLERIES_TABLE . "
			WHERE id = '" . $galleryID ."'"
			);
		return mysql_result($r,0,'title');
	}


	### ADMIN FUNCTIONS ##########
	
	/**
	 * Checks login credentials
	 * @param  array $vars
	 * @return boolean
	 */
	function doLogin($vars){
		$q = sprintf("
			SELECT *
			FROM " . ADMIN_USERS_TABLE ."
			WHERE email='%s' and pword='%s' LIMIT 1",
			mysql_real_escape_string($vars['email']),
			mysql_real_escape_string($vars['pword']));
		
		$r = mysql_query($q);
		
		if(mysql_num_rows($r)>0){ return true; }
		else { return false; }
	}


	/**
	 * Gets total slides in gallery
	 * @param  int $galleryID
	 * @return int Total slide count
	 */
	function getSlidesInGallery($galleryID){
		$q = mysql_query("SELECT count(id)
			FROM " . SLIDES_TABLE . "
			WHERE gallery_id = '" . $galleryID ."'
			");
		return mysql_result($q,0,'count(id)');
	}


	/**
	 * Gets 5 most recent galleries
	 * @param  int $currentGalleryID
	 * @return string HTML code to generate list items
	 */
	function getRecentGalleries($currentGalleryID){
		$q = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			WHERE id != '" . $currentGalleryID . "'
			ORDER BY date_entered desc
			LIMIT 0,5");
		if(mysql_num_rows($q)>0){
			$html ='';
			while ($gallery = mysql_fetch_assoc($q)){
				$html .= '<li class="gallery-list"><a href="../gallery/?' . $gallery['url_code'] . '">' . $gallery['title'] . '</a></li>';
			}

		}
		else {
			$html .= '<li>None currently available.</li>';
		}

		return $html;

	}


	/**
	 * Get list of all galleries in admin
	 * @param  int $page
	 * @return string HTML to write to page
	 */
	function getAdminListing($page){
		$offset = ($page-1)*RESULTS_PERPAGE;

		$r = mysql_query("
			SELECT *
			FROM " . GALLERIES_TABLE . "
			ORDER BY date_entered desc
			LIMIT " . $offset . ", " . RESULTS_PERPAGE);

		$html = array();

		if(mysql_num_rows($r)>0){

			$html['table'] .= '<h2 class="textcenter">Recent Photo Galleries: Admin<br /><br /></h2>';
			$html['table'] .= '<a class="button fancybox" href="add-gallery.php"><i class="fa fa-plus-square m"></i> Add Gallery</a>';
			$html['table'] .= '<table class="gallery-search" cellspacing="0" cellpadding="0">'."\n";
			$html['table'] .= '<tr>'."\n";
			$html['table'] .= '<th>Entered</th><th>Title</th><th>Slides</th><th>Add Slides</th><th>Preview</th><th>Edit</th><th>Delete</th>'."\n";
			$html['table'] .= '</tr>'."\n";

			while ($gallery = mysql_fetch_assoc($r)){
				$slidesInGallery = $this->getSlidesInGallery($gallery['id']);
				$html['table'] .= '<tr>'."\n";
				$html['table'] .= '<td>' . date("m.d.y",strtotime($gallery['date_entered'])) . '</td><td>' . $gallery['title'] . '</td><td>(' . $slidesInGallery . ')</td><td><i class="fa fa-plus-square"></i> <a class="fancybox addslide" gallery-title="'.$gallery['title'].'" gallery-id="'.$gallery['id'].'" href="add-slide.php?id='.$gallery['id'].'">Add Slides</a></td><td><i class="fa fa-picture-o"></i> <a href="../gallery/?' . $gallery['url_code'] . '" target="_blank">Preview</a></td><td><i class="fa fa-pencil-square-o"></i> <a href="edit-gallery.php?id=' . $gallery['id'] . '">Edit</a></td><td><i class="fa fa-trash-o"></i> <a class="fancybox" href="#deletegallery' . $gallery['id'] . '">Delete</a></td>'."\n";
				$html['table'] .= '</tr>'."\n"; 
	
				
				// edit gallery
				$html['hidden'] .= '<div id="editgallery' . $gallery['id'] . '" style="width:640px; display:none;"><h2>Edit Gallery Details:</h2><h3>' . $gallery['title'] . '</h3>';
				$html['hidden'] .= '<form action="" method="post" id="theForm">';
				$html['hidden'] .= '<input type="hidden" name="updateGallery" value="y" />';
				$html['hidden'] .= '<p><label>Title</label><input type="text" class="required" name="title" value="' . $gallery['title'] . '" /></p>';
				$html['hidden'] .= '<p><label>Description</label><textarea class="codeholder" name="description">' . $gallery['description'] . '</textarea></p>';
				$html['hidden'] .= '<p><label></label><input type="submit" class="button" name="submit" value="Update Gallery" /></p>';
				$html['hidden'] .= '</form>';
				$html['hidden'] .= '</div>'."\n";


				// delete gallery
				$html['hidden'] .= '<div id="deletegallery' . $gallery['id'] . '" style="width:640px;display:none;"><h2>Are you sure you want to delete:</h2><h3>' . $gallery['title'] . '?</h3><form action="" method="post"><input type="hidden" name="deleteGallery" value="y" /><input type="hidden" name="id" value="' . $gallery['id'] . '" /><br /><input type="submit" class="button" name="submit" value="Yes, Delete It!" /></form></div>'."\n";
			}


			


			$html['table'] .= '</table>'."\n";

			// add slide to gallery
			$html['hidden'] .= '<div id="add-slide-box" style="width:640px; display:none;"><a class="button" href="#" id="slide-submit">Add Slide</a>';
			$html['hidden'] .= '</div>';


			// add gallery
			$html['hidden'] .= '<div id="add-gallery-box" style="width:640px; display:none;">';
			$html['hidden'] .= '</div>';
			
			return $html;

		}

		else {
			$html .= '<h2>Recent Photo Galleries: Admin</h2>';
			$html .= '<a class="button" href="add-gallery.php"><i class="fa fa-plus-square m"></i> Add Gallery</a>';
			$html .= '<p>There are currently no galleries. You can add one above.</p>';
			return $html;
		}

	}


	/**
	 * Generates URL friendly code
	 * @param  string $title
	 * @return string URL friendly code
	 */
	function urlCode($title){
			$replace="-";
			$title = strtolower(preg_replace("/[^a-zA-Z0-9\.]/",$replace,$title));
			$title = str_replace('.','',$title);
			$title = str_replace('!','',$title);
			$title = str_replace('?','',$title);
			return $title;
	}


	 /**
     * Gets gallery details from urlCode
     * @return array
     */
	function getGalleryDetails($id){
		$q = sprintf("SELECT *
			FROM " . GALLERIES_TABLE . "
			WHERE id = '%s'",
			mysql_real_escape_string($id)
			);

		$r = mysql_query($q);
		return mysql_fetch_assoc($r);
	}


	/**
	 * Insert a gallery into system
	 * @param array $vars
	 * @return  boolean
	 */
	function addGallery($vars){
		$url_code = $this->urlCode($_POST['title']);
		$r = mysql_query("
			INSERT into " . GALLERIES_TABLE . "
			(date_entered, title, description, thumb_url, url_code)
			VALUES
			(NOW(),'" . trim($vars['title']) . "', '" . trim($vars['description']) . "', '" . trim($vars['thumb_url']) . "', '" . $url_code . "')
			");
		return true;
	}


	/**
	 * Update gallery details
	 * @param  array $vars
	 * @return booelan
	 */
	function updateGallery($vars){
		$url_code = $this->urlCode($vars['title']);
		$r = mysql_query("
			UPDATE " . GALLERIES_TABLE . "
			SET title = '" . trim($vars['title']) . "',
			description = '" . trim($vars['description']) . "',
			thumb_url = '" . trim($vars['thumb_url']) . "',
			url_code = '" . $url_code. "'
			WHERE id='" . $vars['id'] ."'
			");
		return true;
	}


	/**
	 * Delete gallery from system
	 * @param  int $galleryID
	 * @return boolean
	 */
	function deleteGallery($galleryID){
		$r = mysql_query("
			DELETE
			FROM " . GALLERIES_TABLE . "
			WHERE id='" . $galleryID ."'
			");
		return true;
	}


	/**
	 * Add a slide to a gallery
	 * @param array $vars
	 * @return  int ID of last slide added
	 */
	function addSlide($vars){
		if(substr($vars['code'],0,4)=='http'){
			$vars['code'] = '<img src="' . $vars['code'] . '" />'; 
		}
		$r = mysql_query("
			INSERT into " . SLIDES_TABLE . "
			(code,description,gallery_id)
			VALUES
			('" . $vars['code'] . "', '" . trim($vars['description']) . "', '" . $vars['gallery_id'] . "')
			");
		return mysql_insert_id();
	}


	/**
	 * Delete slide from gallery
	 * @param  int $slideID
	 * @return boolean
	 */
	function deleteSlide($slideID){
		$r = mysql_query("
			DELETE
			FROM " . SLIDES_TABLE . "
			WHERE id='" . $slideID ."'
			");
		return true;
	}


	/**
	 * Get most recent slide in gallery
	 * @param  int $galleryID
	 * @return array Slide details
	 */
	function getLastSlide($galleryID){
		$r = mysql_query("
			SELECT *
			FROM " . SLIDES_TABLE . "
			WHERE gallery_id='" . $galleryID ."'
			ORDER BY id DESC limit 0,1
			");
		if(mysql_num_rows($r)>0){
			return mysql_fetch_assoc($r);
		}
		else {
			return false;
		}
	}

	function fbShare($galleryTitle, $urlCode, $thumbImg){
		$html =  '<a class="fright" href="https://www.facebook.com/dialog/feed?app_id=' . FB_APP_ID . '&link=http://'. $_SERVER['HTTP_HOST'] . '/common/gallery/?' . $urlCode . '&picture=' . $thumbImg . '&name='.$galleryTitle .'.&caption=Check+out+this+gallery+on+' . $_SERVER['HTTP_HOST'] . '&description=View+Now&redirect_uri=http://'. $_SERVER['HTTP_HOST'] . '/common/gallery/?' . $urlCode . '" target="_blank"><i class="fa fa-facebook-square"></i> Share on Facebook</a></span>';
	    return $html;			
	}

}




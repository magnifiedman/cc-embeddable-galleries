<?php
/* Embeddable Photo Galleries Configuration File
 * Original Creation Date 05.2014
 * Wherein we define some constants for the system
 */

	error_reporting(E_ERROR);
	ini_set('display_errors', 1);

	// site paths
		//define('BASE_URL','/cc-embeddable-galleries/'); // local
		//define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'] . '/cc-embeddable-galleries/'); // local
		define('BASE_URL',''); // use for cc
		define('ROOT_PATH',''); // use for cc


	// database connection - local development
		/*define('DB_HOST','localhost');
		define('DB_USER','root');
		define('DB_PASS','root');
		define('DB_NAME','devdb');*/


	// database connection - production
		define('DB_HOST','');
		define('DB_USER','');
		define('DB_PASS','');
		define('DB_NAME','');


	// database tables
		define('GALLERIES_TABLE','cc_embeddable_galleries');
		define('SLIDES_TABLE','cc_embeddable_galleries_slides');
		define('ADMIN_USERS_TABLE','cc_embeddable_galleries_users_admin');


	// data
		define('RESULTS_PERPAGE','25');


	// ads and facebook share - EDIT
		define('AD_MARKET','PHOENIX-AZ');

		switch($_SERVER['HTTP_HOST']){
			

			// 104.7 KISSFM
			case 'www.1047kissfm.com':
			$shortName = 'kiss';
			$stationName = '104.7 KISS FM';
			$iheartID=61;
			define('STATION_TWITTER','@kissfmphoenix');
			define('FB_APP_ID','118663364875290');
			define('AD_STATION','kzzp-fm');
			define('AD_FORMAT','CHRPOP');
			break;

			// KNIX 102.5
			case 'www.knixcountry.com':
			$shortName = 'knix';
			$stationName = '102.5 KNIX';
			$iheartID=49;
			define('STATION_TWITTER','@knixcountry');
			define('FB_APP_ID','112504248829094');
			define('AD_STATION','knix-fm');
			define('AD_FORMAT','COUNTRY');
			break;

			// MIX 96.9
			case 'www.mix969.com':
			$shortName = 'mix';
			$stationName = 'MIX 96.9';
			$iheartID=45;
			define('STATION_TWITTER','@mix969');
			define('FB_APP_ID','641550595885472');
			define('AD_STATION','kmxp-fm');
			define('AD_FORMAT','ACHOTMODERN');
			break;

			// 99.9 KEZ
			case 'www.kez999.com':
			$shortName = 'kez';
			$stationName = '99.9 KEZ';
			$iheartID=33;
			define('STATION_TWITTER','@999kez');
			define('FB_APP_ID','257993677563555');
			define('AD_STATION','kesz-fm');
			define('AD_FORMAT','ACMAINSTREAM');
			break;

			// 95.5 Mountain
			case 'www.955themountain.com':
			$shortName = 'mtn';
			$stationName = '95.5 The Mountain';
			$fbAppID = '200317206814408';
			$iheartID=57;
			define('STATION_TWITTER','@955themountain');
			define('FB_APP_ID','200317206814408');
			define('AD_STATION','kyot-fm');
			define('AD_FORMAT','CLASSICHITS');
			break;

			// Fox Sports 910
			case 'www.foxsports910':
			$shortName = 'foxsports';
			$stationName = 'Fox Sports 910';
			$iheartID=41;
			define('STATION_TWITTER','@foxsports910');
			define('FB_APP_ID','469468233068339');
			define('AD_STATION','kgme-am');
			define('AD_FORMAT','SPORTS');
			break;

			// 550 KFYI
			case 'www.kfyi.com':
			$shortName = 'kfyi';
			$stationName = '550 KFYI';
			$iheartID=37;
			define('STATION_TWITTER','@kfyi');
			define('FB_APP_ID','');
			define('AD_STATION','kfyi-am');
			define('AD_FORMAT','NEWSTALK');
			break;

			// 550 KFYI
			case 'www.kfyi.biz':
			define('FB_APP_ID','');
			define('AD_STATION','koy-am');
			define('AD_FORMAT','NEWSTALK');
			break;
		}




	
cc-embeddable-galleries
======================
traviswachendorf@clearchannel.com

* This app will be programmed in PHP 4.4.9 *

* Live version: http://www.knixcountry.com/common/gallery/?national-hot-dog-day- *

App to display embeddable galleries on CC websites (Instagram, Twitter, Vine)

These files are meant to create:
- Front end gallery display page
- Simple admin to allow gallery data entry and management

Server Requirements:
- MySQL Database

Installation Instructions
- 1. Create a database on your MYSQL Server
- 2. Run -setup/cc_embeddable_galleries.sql- in your MYSQL client to create tables
- 3. Create at least 1 user in the -- cc_embeddable_galleries_users_admin -- table
- 4. In the -lib/config.inc.php- you need to do 2 things.
	- Set up database connection credentials and filepath constants in -lib/config.inc.php- file and comment out local settings
	- Set up your station site details (ad market, format, FB app id's) in the section titled // ads and facebook share - EDIT
- 5. Place all files and folders on your COMMON server in a folder called "gallery"
- 6. To create galleries, go to http://yourstationwebsite.com/common/gallery/admin.php and log in.


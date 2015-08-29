<?php
/**
 * Elgg OverDrive
 *
 * @package OverDrive
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

elgg_register_event_handler('init', 'system', 'overdrive_init');

// Init wall posts
function overdrive_init() {
	// Register library
	elgg_register_library('elgg:overdrive', elgg_get_plugins_path() . 'overdrive/lib/overdrive.php');
	elgg_load_library('elgg:overdrive');

	// Overdrive page handler
	elgg_register_page_handler('overdrive', 'overdrive_page_handler');
}

/**
 * Overdrive page handler
 *
 * @param array $page Array of url parameters
 * @return bool
 */
function overdrive_page_handler($page) {
	switch ($page[0]) {
		case 'authenticate':
			// // Force HTTPS
			// if($_SERVER['SERVER_PORT'] != 443) {
			// 	$ssl_root = str_replace('http://','https://', elgg_get_site_url());
			// 	header("HTTP/1.1 301 Moved Permanently");
			// 	header("Location: " . $ssl_root . "overdrive/authenticate");
			// 	exit();
			// }
			// Get username/password from querystring (librarycard/pin)
			$username = get_input('LibraryCard');
			$password = get_input('PIN');
			overdrive_authenticate($username, $password);
			return TRUE;
			break;
		default:
			forward();
			break;
	}
	return FALSE;
}
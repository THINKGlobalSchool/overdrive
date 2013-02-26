<?php
/**
 * Elgg OverDrive Helper Library
 *
 * @package OverDrive
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

/**
 * Wrap elgg_authenticate
 *
 * @param $username string Username
 * @param $password string Password
 * @return void
 */
function overdrive_authenticate($username, $password) {
	// check if logging in with email address
	if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
		$username = $users[0]->username;
	}

	$result = elgg_authenticate($username, $password);

	if ($result === TRUE) {
		// Get user entity
		$user = get_user_by_username($username);

		// Sanity check
		if (!$user) {
			$status = 0;
			$message = elgg_echo('login:baduser');
		}

		// Check for banned status
		if ($user->isBanned()) {
			$status = 0;
			$message = elgg_echo('LoginException:BannedUser');
		} else {
			// All good!
			$status = 1;
		}

		// Response
		overdrive_response($status, $message);
	} else {
		// Bad authenticate response
		overdrive_response(0, elgg_echo($result));
	}
}

/**
 * Format XML response for overdrive authentication
 *
 * @param $status  int   Status (0 or 1)
 * @param $message mixed Optional message
 */
function overdrive_response(int $status, $message = NULL) {
	$response = new SimpleXMLElement('<AuthorizeResponse/>');
	$response->addChild('Status', $status);

	// If positive status and a message was provided, output it
	if ($status && $message) {
		$response->addChild('Message', $message);
	} else if ($message) {
		// Error message
		$response->addChild('ErrorDetails', $message);
	}

	Header('Content-type: text/xml');
	print($response->asXML());
}
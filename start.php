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

	// Register actions
	$action_base = elgg_get_plugins_path() . 'overdrive/actions/overdrive';
	//elgg_register_action("overdrive/authenticate", "$action_base/authenticate.php");
}
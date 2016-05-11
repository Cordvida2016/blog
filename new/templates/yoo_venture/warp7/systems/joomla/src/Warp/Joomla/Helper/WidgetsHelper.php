<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Joomla\Helper;

use Warp\Warp;
use Warp\Helper\AbstractHelper;

/**
 * Widget helper class, count/render widgets.
 */
class WidgetsHelper extends AbstractHelper
{
   /**
    * Document
    * @var object
    */
	public $document;

   /**
    * Module renderer.
    * @var object
    */
	public $renderer;

	/**
	 * Constructor.
	 */
    public function __construct(Warp $warp)
    {
        parent::__construct($warp);

		$this->document = \JFactory::getDocument();
		$this->renderer = $this->document->loadRenderer('module');
	}

	/**
	 * Retrieve the active module count at a position
	 *
	 * @param  string $position
	 * @return integer
	 */
	public function count($position) {
		return $this->document->countModules($position);
	}

	/**
	 * Shortcut to render a position
	 *
	 * @param  string $position
	 * @param  array  $args
	 * @return string
	 */
	public function render($position, $args = array()) {

		// set position in arguments
		$args['position'] = $position;

		return $this['template']->render('widgets', $args);
	}

	/**
	 * Retrieve module objects for a position
	 *
	 * @param  string $position
	 * @return array
	 */
	public function load($position) {

		// init vars
		$modules = \JModuleHelper::getModules($position);

        return $this->attachParams($modules);
	}

	/**
	 * Retrieve module objects for given positions.
	 *
     * @param string[] $positions The positions to load modules for
     * @param int $clientId The clientId to filter for
     *
	 * @return  array
	 */
	public function loadForPositions(array $positions = array(), $clientId = 0)
	{
        if (empty($positions)) {
            return array();
        }

		$db = \JFactory::getDbo();
		$user = \JFactory::getUser();
		$groups = implode(',', $user->getAuthorisedViewLevels());

		// create query
		$query = $db->getQuery(true);
		$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params');
		$query->from('#__modules AS m');
        $query->where('m.position IN (' . implode(',', array_map(function($position) use ($db) { return $db->quote($position); }, $positions)) . ')');
		$query->where('m.access IN (' . $groups . ')');
		$query->where('m.client_id = ' . $clientId);
		$query->order('m.position, m.ordering');

		// set query
		$db->setQuery($query);

		try {
			$modules = $db->loadObjectList();
		} catch (\RuntimeException $e) {
			\JLog::add(\JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $e->getMessage()), \JLog::WARNING, 'jerror');
            $modules = array();
		}

        return $this->attachParams($modules);
	}

    /**
     * Get widgets grouped by position.
     *
     * @return array
     */
    public function getWidgets()
    {
        $return = array();

        if (!$tmpl_xml = $this['dom']->create($this['path']->path('theme:templateDetails.xml'), 'xml')) {
            return $return;
        }

        // get position settings
        $position_settings = array();

        foreach ($tmpl_xml->find('positions > position') as $position) {
            $position_settings[$position->text()] = $position;
        }

        $modules = $this->loadForPositions(array_keys($position_settings));

        foreach ($position_settings as $name => $position) {
            if ($widgets = array_filter($modules, function($module) use ($name) { return $module->position === $name; })) {

                $return[$name] = array();

                foreach ($widgets as $widget) {
                    $return[$name][] = array("id" => $widget->id, "title" => $widget->title);
                }
            }
        }

        return $return;
    }

    /**
     * Attach config params to modules
     * @param array $modules
     * @return array
     */
    protected function attachParams($modules = array())
    {
        // set params, force no style
		$params['style'] = 'none';

		// get modules content
		foreach ($modules as $module) {
			$module->parameter = new \JRegistry($module->params);
			$module->menu = $module->module == 'mod_menu';
			$module->content = $this->renderer->render($module, $params);
		}

		return $modules;
    }
}
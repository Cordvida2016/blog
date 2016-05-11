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
 * Joomla! system helper class, provides Joomla! CMS integration (http://www.joomla.org).
 */
class SystemHelper extends AbstractHelper
{
	/**
	 * System application.
	 *
	 * @var object
	 */
	public $application;

	/**
	 * System document.
	 *
	 * @var object
	 */
	public $document;

	/**
	 * System language.
	 *
	 * @var object
	 */
	public $language;

    /*
     * System root path.
     *
     * @var string
     */
    public $path;

    /*
     * System root url.
     *
     * @var string
     */
    public $url;

    /*
     * Cache path.
     *
     * @var string
     */
    public $cache_path;

    /*
     * Cache time.
     *
     * @var int
     */
    public $cache_time;

    /**
     * Dynamic style GET variable.
     *
     * @var string
     */
    protected $style = 'style';

    /**
     * Constructor.
     *
     * @param Warp $warp
     */
    public function __construct(Warp $warp)
    {
        parent::__construct($warp);

	    jimport('joomla.filesystem.folder');

		// init vars
		$this->application = \JFactory::getApplication();
        $this->document    = \JFactory::getDocument();
		$this->language    = \JFactory::getLanguage();
        $this->path        = JPATH_ROOT;
        $this->url         = rtrim(\JURI::root(false), '/');
        $this->cache_path  = $this->path.'/cache/template';
        $this->cache_time  = max(\JFactory::getConfig()->get('cachetime') * 60, 86400);

        // set config or load defaults
		$this['config']->load($this['path']->path('theme:config.json') ?: $this['path']->path('theme:config.default.json'));

		// set cache directory
		if (!file_exists($this->cache_path)) {
			\JFolder::create($this->cache_path);
		}
	}

	/**
	 * Initialize system.
	 */
	public function init()
	{
		// set paths
        $this['path']->register($this->path, 'site');
        $this['path']->register($this->path.'/administrator', 'admin');
        $this['path']->register($this->path.'/cache/template', 'cache');

		// set translations
		$this->language->load('tpl_warp', $this['path']->path('warp:systems/joomla'), null, true);

		// init site/admin
		if ($this->application->isSite()) $this->initSite();
		if ($this->application->isAdmin()) $this->initAdmin();
	}

	/**
	 * Initialize site.
	 */
	public function initSite()
	{
		// get application
		$app = $this->application;

		// set config
		$this['config']['language'] = $this->document->language;
		$this['config']['direction'] = $this->document->direction;
		$this['config']['site_url'] = rtrim(\JURI::root(), '/');
		$this['config']['site_name'] = $app->getCfg('sitename');
		$this['config']['datetime'] = \JHTML::_('date', 'now', 'Y-m-d');
		$this['config']['actual_date'] = \JHTML::_('date', 'now', \JText::_('DATE_FORMAT_LC'));

		// branding ?
		if ($this['config']->get('warp_branding', true)) {
			$this['template']->set('warp_branding', $this['config']['branding']);
		}

        // set layouts
        if ($layouts = $this['config']['layouts']) {

            $layout = 'default';
            $itemid = $app->input->getInt('Itemid', 0);

            // add menu item layout?
            foreach ($layouts as $key => $data) {
                if (isset($data['assignment']) && in_array($itemid, $data['assignment'])) {
                    $layout = $key;
                    break;
                }
            }

            $this['config']->setValues($layouts[$layout]);
        }

        // set dynamic style
        if ($this['config']['dynamic_style']) {

            if ($var = $app->input->get($this->style)) {
                $app->setUserState('_style', $var);
            }

            if ($dynamic = $app->getUserState('_style')) {
                $this['config']['style'] = $dynamic;
            }
        }

		// set theme style paths
		if ($style = $this['config']->get('style', 'default') and $path = $this['path']->path(sprintf('theme:css/styles/%s', $style))) {
            $this['path']->register($path, 'css');
		}

		// force show system output on search results
		if (strtolower($this->application->input->get('option')) == 'com_search') {
			$this['config']['system_output'] = 1;
		}
	}

	/**
	 * Initialize administration area.
	 */
	public function initAdmin()
	{
		// get xml's
		$tmpl_xml = $this['dom']->create($this['path']->path('theme:templateDetails.xml'), 'xml');
		$warp_xml = $this['dom']->create($this['path']->path('warp:warp.xml'), 'xml');

		// cache writable ?
		if (!file_exists($this->cache_path) || !is_writable($this->cache_path)) {
			$messages[] = "Cache not writable, please check directory permissions ({$this->cache_path})";
		}

		// update check
		if ($url = $warp_xml->first('updateUrl')->text()) {

			// create check urls
			$urls['tmpl'] = sprintf('%s?application=%s&version=%s&format=raw', $url, $tmpl_xml->first('name')->text().'_j25', $tmpl_xml->first('version')->text());
			$urls['warp'] = sprintf('%s?application=%s&version=%s&format=raw', $url, 'warp', $warp_xml->first('version')->text());

			foreach ($urls as $type => $url) {

				// only check once a day
				$hash = md5($url.date('Y-m-d'));
				if ($this['option']->get("{$type}_check") != $hash) {
					if ($request = $this['http']->get($url)) {
						$this['option']->set("{$type}_check", $hash);
						$this['option']->set("{$type}_data", $request['body']);
					}
				}

				// decode response and set message
				if (($data = json_decode($this['option']->get("{$type}_data"))) && $data->status == 'update-available') {
					$messages[] = $data->message;
				}
			}
		}

		// set messages
		if (isset($messages)) {
			$this['template']->set('messages', $messages);
		}
	}

	/**
	 * Ajax callback.
	 */
	public function ajaxCallback($task)
	{
		switch ($task) {

			case 'config':

				// init vars
				$file = $this['path']->path('theme:').'/config.json';

				// parse config
		        parse_str(isset($_POST['config']) ? $_POST['config'] : '', $config);

				// save config file
				$message = count($config) && \JFile::write($file, json_encode($config)) ? 'success' : 'failed';

				break;

			case 'files':

				// init vars
				$files = isset($_POST['files']) ? $_POST['files'] : array();
				$path  = $this['path']->path('theme:');

               	$message = 'success';

				foreach ($files as $file => $data) {
					if (\JFile::write($path.$file, $data) === false) {
						$message = 'failed';
						break;
					}
				}

                // delete obsolete style files
                if ($path = $this['path']->path('less:styles')) {
                    foreach (glob("$path/*.less") as $file) {
                        if (!isset($files["/less/styles/".basename($file)])) {
                            if ($folder = $this['path']->path('css:styles/'.basename($file, '.less'))) {
                                \JFolder::delete($folder);
                            }
                            \JFile::delete($file);
                        }
                    }
                }

				break;
            case 'styles':

                // render styles config
                echo $this['template']->render('config:layouts/styles');
                return;
		}

		if (isset($message)) {
			echo json_encode(compact('message'));
		}
	}

    /**
     * Is current view a blog?
     *
     * @return boolean
     */
	public function isBlog()
	{
		// get application
		$app = $this->application;

		if ($app->input->get('option') == 'com_content') {
			if (in_array($app->input->get('view'), array('frontpage', 'article', 'archive', 'featured')) || ($app->input->get('view') == 'category' && $app->input->get('layout') == 'blog')) {
				return true;
			}
		}

		if ($app->input->get('option') == 'com_zoo' && !in_array($app->input->get('task'), array('submission', 'mysubmissions')) && $a = \App::getInstance('zoo')->zoo->getApplication() and $a->getGroup() == 'blog') {
			return true;
		}

		return false;
	}
}

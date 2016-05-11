<?php
/**
 * @version		$Id: lpdparameter.php 1334 2011-11-25 13:37:52Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.html.parameter' );

/**
 * Parameter handler
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */
class LPDParameter extends JParameter
{
	
	/**
	* optional namespace
	*
	* @access	private
	* @var		array
	* @since	1.5
	*/
	var $namespace = null;
	
	/**
	 * Constructor
	 *
	 * @access	protected
	 * @param	string The raw parms text
	 * @param	string Path to the xml setup file
	 * @param	string Namespace to the xml setup file
	 * @since	1.5
	 */
	function __construct($data, $path = '', $namespace)
	{
		parent::__construct('_default');

		// Set base path
		$this->_elementPath[] = JPATH_COMPONENT_ADMINISTRATOR.DS.'elements';

		if (trim( $data )) {
			$this->loadINI($data);
		}

		if ($path) {
			$this->loadSetupFile($path);
		}
		
		if ($namespace) {
			$this->namespace = $namespace;
		}

		$this->_raw = $data;
		
		if(LPD_JVERSION == '16') {
			$this->bind($data);
		}
	}

	/**
	 * Get a value
	 *
	 * @access	public
	 * @param	string The name of the param
	 * @param	mixed The default value if not found
	 * @return	string
	 * @since	1.5
	 */
	function get($key, $default = '', $group = '_default')
	{
		if(LPD_JVERSION == '16') {
			return parent::get($this->namespace.$key, $default);
		}
		$value = $this->getValue($group.'.'.$this->namespace.$key);
		$result = (empty($value) && ($value !== 0) && ($value !== '0')) ? $default : $value;
		//if($group != '_default') { echo ($group); }
		return $result;
	}

	/**
	 * Render a parameter type
	 *
	 * @param	object	A param tag node
	 * @param	string	The control name
	 * @return	array	Any array of the label, the form element and the tooltip
	 * @since	1.5
	 */
	function getParam(&$node, $control_name = 'params', $group = '_default')
	{
		//get the type of the parameter
		$type = $node->attributes('type');

		//remove any occurance of a mos_ prefix
		$type = str_replace('mos_', '', $type);

		$element =& $this->loadElement($type);

		// error happened
		if ($element === false)
		{
			$result = array();
			$result[0] = $node->attributes('name');
			$result[1] = JText::_('LPD_ELEMENT_NOT_DEFINED_FOR_TYPE').' = '.$type;
			$result[5] = $result[0];
			return $result;
		}

		//get value
		$value	= $this->get($node->attributes('name'), $node->attributes('default'), $group);

		//set name
		$node->_attributes['name'] = $this->namespace.$node->_attributes['name'];

		return $element->render($node, $value, $control_name);
	}
	
	
	/**
	 * Get a registry value
	 *
	 * @access	public
	 * @param	string	$regpath	Registry path (e.g. joomla.content.showauthor)
	 * @param	mixed	$default	Optional default value
	 * @return	mixed	Value of entry or null
	 * @since	1.5
	 */
	function getValue($regpath, $default=null)
	{
		$result = $default;

		// Explode the registry path into an array
		if ($nodes = explode('.', $regpath))
		{
			// Get the namespace
			//$namespace = array_shift($nodes);
			$count = count($nodes);
			if ($count < 2) {
				$namespace	= $this->_defaultNameSpace;
				$nodes[1]	= $nodes[0];
			} else {
				$namespace = $nodes[0];
			}

			if (isset($this->_registry[$namespace])) {
				$ns = & $this->_registry[$namespace]['data'];
				$pathNodes = $count - 1;

				//for ($i = 0; $i < $pathNodes; $i ++) {
				for ($i = 1; $i < $pathNodes; $i ++) {
					if((isset($ns->$nodes[$i]))) $ns =& $ns->$nodes[$i];
				}

				if(isset($ns->$nodes[$i])) {
					$result = $ns->$nodes[$i];
				}
			}
		}
		return $result;
	}
	
	/**
	 * Render
	 *
	 * @access	public
	 * @param	string	The name of the control, or the default text area if a setup file is not found
	 * @return	string	HTML
	 * @since	1.5
	 */
	function render($name = 'params', $group = '_default')
	{
		if (!isset($this->_xml[$group])) {
			return false;
		}

		$params = $this->getParams($name, $group);
		$html = array ();
		$html[] = '<table class="paramlist admintable" cellspacing="1">';

		if ($description = $this->_xml[$group]->attributes('description')) {
			// add the params description to the display
			$desc	= JText::_($description);
			$html[]	= '<tr><td class="paramlist_description" colspan="2">'.$desc.'</td></tr>';
		}

		foreach ($params as $param)
		{
			$html[] = '<tr>';

			if ($param[0]) {
				$html[] = '<td class="paramlist_key"><span class="editlinktip">'.$param[0].'</span></td>';
				$html[] = '<td class="paramlist_value">'.$param[1].'</td>';
			} else {
				$html[] = '<td class="paramlist_value" colspan="2">'.$param[1].'</td>';
			}

			$html[] = '</tr>';
		}

		if (count($params) < 1) {
			$html[] = "<tr><td colspan=\"2\"><i>".(LPD_JVERSION == '16')? JText::_('JLIB_HTML_NO_PARAMETERS_FOR_THIS_ITEM') : JText::_('There are no Parameters for this item')."</i></td></tr>";
		}

		$html[] = '</table>';

		return implode("\n", $html);
	}
}
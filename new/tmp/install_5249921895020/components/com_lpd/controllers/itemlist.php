<?php
/**
 * @version		$Id: itemlist.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class LPDControllerItemlist extends JController
{

    function display() {
        $model=&$this->getModel('item');
        $format=JRequest::getWord('format','html');
        $document =& JFactory::getDocument();
        $viewType = $document->getType();
        $view = &$this->getView('itemlist', $viewType);
        $view->setModel($model);
        $user = &JFactory::getUser();
        if ($user->guest){
            $cache = true;
        }
        else {
            $cache = false;
        }
        parent::display($cache);
    }

    function calendar(){

        require_once (JPATH_SITE.DS.'modules'.DS.'mod_lpd_tools'.DS.'includes'.DS.'calendarClass.php');
        require_once (JPATH_SITE.DS.'modules'.DS.'mod_lpd_tools'.DS.'helper.php');
        $mainframe = &JFactory::getApplication();
        $month = JRequest::getInt('month');
        $year = JRequest::getInt('year');

        $months = array (JText::_('LPD_JANUARY'), JText::_('LPD_FEBRUARY'), JText::_('LPD_MARCH'), JText::_('LPD_APRIL'), JText::_('LPD_MAY'), JText::_('LPD_JUNE'), JText::_('LPD_JULY'), JText::_('LPD_AUGUST'), JText::_('LPD_SEPTEMBER'), JText::_('LPD_OCTOBER'), JText::_('LPD_NOVEMBER'), JText::_('LPD_DECEMBER'), );
        $days = array (JText::_('LPD_SUN'), JText::_('LPD_MON'), JText::_('LPD_TUE'), JText::_('LPD_WED'), JText::_('LPD_THU'), JText::_('LPD_FRI'), JText::_('LPD_SAT'), );

        $cal = new MyCalendar;
        $cal->setMonthNames($months);
        $cal->setDayNames($days);
        $cal->category = JRequest::getInt('catid');
        $cal->setStartDay(1);

        if (($month) && ($year)) {
            echo $cal->getMonthView($month, $year);
        }
        else {
            echo $cal->getCurrentMonthView();
        }

        $mainframe->close();
    }

    function module(){

        $document =& JFactory::getDocument();
        $view = &$this->getView('itemlist', 'raw');
        $model=&$this->getModel('itemlist');
        $view->setModel($model);
        $model=&$this->getModel('item');
        $view->setModel($model);
        $view->module();

    }

}

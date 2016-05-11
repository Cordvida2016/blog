<?php
/**
 * @version		$Id: lpd.php 1373 2011-11-29 15:59:12Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgUserLPD extends JPlugin {

    function plgUserLPD(&$subject, $config) {

        parent::__construct($subject, $config);
    }

    function onUserAfterSave($user, $isnew, $success, $msg) {
    	return $this->onAfterStoreUser($user, $isnew, $success, $msg);
    }
    
    function onUserLogin($user, $options) {
    	return $this->onLoginUser($user, $options);
    }
    
    function onUserLogout($user) {
    	return $this->onLogoutUser($user);
    }
    
    function onUserAfterDelete($user, $success, $msg){
    	return $this->onAfterDeleteUser($user, $success, $msg);
    }
    
    function onUserBeforeSave($user, $isNew){
    	return $this->onBeforeStoreUser($user, $isNew);
    }
    
    function onAfterStoreUser($user, $isnew, $success, $msg) {

    	$mainframe = &JFactory::getApplication();
    	$params = &JComponentHelper::getParams('com_lpd');
    	jimport('joomla.filesystem.file');
		$task = JRequest::getCmd('task');
    	
    	if($mainframe->isSite() && $task != 'activate' && JRequest::getInt('LPDUserForm')) {
    		JPlugin::loadLanguage('com_lpd');
    		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'tables');
    		$row = &JTable::getInstance('LPDUser', 'Table');
    		$lpdid = $this->getLPDUserID($user['id']);
    		JRequest::setVar('id', $lpdid, 'post');
    		$row->bind(JRequest::get('post'));
    		$row->set('userID', $user['id']);
    		$row->set('userName', $user['name']);
    		if($isnew)
    		$row->set('group', $params->get('LPDUserGroup', 1));
    		else
    		$row->set('group', NULL);
    		$row->set('gender', JRequest::getVar('gender'));
    		$row->set('url', JRequest::getVar('url'));

    		$row->set('description', JRequest::getVar('description', '', 'post', 'string', 2));
    		if($params->get('xssFiltering')){
    			$filter = new JFilterInput(array(), array(), 1, 1, 0);
    			$row->description = $filter->clean( $row->description );
    		}

    		$file = JRequest::get('files');

    		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'class.upload.php');
    		$savepath = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'users'.DS;

    		if (isset($file['image']) && $file['image']['error'] == 0 && !JRequest::getBool('del_image')) {
    			$handle = new Upload($file['image']);
    			$handle->allowed = array('image/*');
    			if ($handle->uploaded) {
    				$handle->file_auto_rename = true;
    				$handle->file_overwrite = false;
    				$handle->file_new_name_body = $row->id;
    				$handle->image_resize = true;
    				$handle->image_ratio_y = true;
    				$handle->image_x = $params->get('userImageWidth', '100');
    				$handle->Process($savepath);
    				$handle->Clean();
    			} else {
    				$mainframe->enqueueMessage(JText::_('LPD_COULD_NOT_UPLOAD_YOUR_IMAGE').$handle->error, 'notice');
    			}
    			$row->image = $handle->file_dst_name;
    		}

    		if (JRequest::getBool('del_image')) {

    			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'users'.DS.$row->image)) {
    				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'users'.DS.$row->image);
    			}
    			$row->image = '';
    		}

    		$row->store();
    		$itemid = $params->get('redirect');

    		if(!$isnew && $itemid){
    			$menu =& JSite::getMenu();
    			$item = $menu->getItem($itemid);
    			$url = JRoute::_($item->link.'&Itemid='.$itemid, false);
    			if (JURI::isInternal($url)) {
    				$mainframe->redirect( $url, JText::_('LPD_YOUR_SETTINGS_HAVE_BEEN_SAVED') );
    			}
    		}
    	}

    }
    
    function onLoginUser($user, $options) {
    	$params = &JComponentHelper::getParams('com_lpd');
        $mainframe = &JFactory::getApplication();
        if($mainframe->isSite() && $params->get('cookieDomain')){
            $tmp = &JFactory::getUser();
            setcookie ("userID", $tmp->id, 0, '/', $params->get('cookieDomain'), 0 );  
        }
        return true;
    }

    function onLogoutUser($user){
    	$params = &JComponentHelper::getParams('com_lpd');
        $mainframe = &JFactory::getApplication();
        if($mainframe->isSite() && $params->get('cookieDomain')){
            setcookie ("userID", 'false', 0, '/', $params->get('cookieDomain'), 0 );  
        }
        return true;
    }

    function onAfterDeleteUser($user, $succes, $msg) {

        $mainframe = &JFactory::getApplication();
        $db = &JFactory::getDBO();
        $query = "DELETE FROM #__lpd_users WHERE userID={$user['id']}";
        $db->setQuery($query);
        $db->query();
    }
    
	function onBeforeStoreUser($user, $isNew) {
		$mainframe = &JFactory::getApplication();
		$params = &JComponentHelper::getParams('com_lpd');
		$session = &JFactory::getSession();
		if($params->get('LPDUserProfile') && $isNew && $params->get('recaptchaOnRegistration') && $mainframe->isSite() && !$session->get('socialConnectData')) {
			require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'recaptchalib.php');
			$privatekey = $params->get('recaptcha_private_key');
			$recaptcha_challenge_field = isset($_POST["recaptcha_challenge_field"])? $_POST["recaptcha_challenge_field"]:'';
			$recaptcha_response_field = isset($_POST["recaptcha_response_field"])? $_POST["recaptcha_response_field"]:'';
			$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $recaptcha_challenge_field, $recaptcha_response_field);
			if (!$resp->is_valid) {
				if(LPD_JVERSION == '16') {
					$url = 'index.php?option=com_users&view=registration';
				}
				else {
					$url = 'index.php?option=com_user&view=register';
				}
				$mainframe->redirect($url, JText::_('LPD_THE_WORDS_YOU_TYPED_DID_NOT_MATCH_THE_ONES_DISPLAYED_PLEASE_TRY_AGAIN'), 'error');
			}
		}
	}

    function getLPDUserID($id) {

        $db = &JFactory::getDBO();
        $query = "SELECT id FROM #__lpd_users WHERE userID={$id}";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

}

<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Joomla\Helper;

/**
 * System check helper class.
 */
class CheckHelper extends \Warp\Helper\CheckHelper
{
    /**
     * Check if the debug plugin is disabled.
     *
     * @return boolean
     */
    public function checkDebugPluginDisabled()
    {
        if ($enabled = \JPluginHelper::isEnabled('system', 'debug')) {
            $this->issues['critical'][] = sprintf("System - Debug Plugin enabled. This might cause memory issues, while compiling the LESS files.");
        }

        return !$enabled;
    }
}

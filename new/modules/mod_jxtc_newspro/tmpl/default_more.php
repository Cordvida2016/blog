<?php
/*
	JoomlaXTC Wall Renderer

	version 1.10

	Copyright (C) 2010,2011,2012,2013  Monev Software LLC.	All Rights Reserved.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

	THIS LICENSE IS NOT EXTENSIVE TO ACCOMPANYING FILES UNLESS NOTED.

	See COPYRIGHT.php for more information.
	See LICENSE.php for more information.

	Monev Software LLC
	www.joomlaxtc.com
*/

defined( '_JEXEC' ) or die;

$items = $moreclone ? array_slice($cloneditems,0,$moreqty) : array_slice($items,0,$moreqty);
if (count($items) == 0) { return; }

$moreareahtml = '';
$rowmaxintro = $moremaxintro;
$rowmaxtitle = $moremaxtitle;
$rowmaxtext = $moremaxtext;
$rowmaxintrosuf = $moremaxintrosuf;
$rowmaxtitlesuf = $moremaxtitlesuf;
$rowmaxtextsuf = $moremaxtextsuf;
$rowtextbrk = $moretextbrk;
if ($morelegend) {
    $moreareahtml .= '<a style="color:#' . $morelegendcolor . '">' . $morelegend . '</a><br/>';
}
$moreareahtml .= '<table class="jnp_more" border="0" cellpadding="0" cellspacing="0">';
$c = 1;
$cnt = 0;
foreach ($items as $item) {
    if ($c == 1) {
        $moreareahtml .= '<tr>';
    }
    $itemhtml = $moretemplate;
    require JModuleHelper::getLayoutPath($module->module, 'default_parse');
    $moreareahtml .= '<td>' . $itemhtml . '</td>';
    $c++;
    if ($c > $morecols) {
        $moreareahtml .= '</tr>';
        $c = 1;
    }
}
if ($c > 1)
    $moreareahtml .= '</tr>';
$moreareahtml .= '</table>';

$modulehtml = str_replace('{morearea}', $moreareahtml, $modulehtml);

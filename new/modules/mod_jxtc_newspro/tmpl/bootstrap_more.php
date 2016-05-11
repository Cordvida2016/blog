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

$index=1;
$spanClass = 'span'.floor((12/$morecols));
$rows = ceil($moreqty/$morecols);

$moreareahtml = '<div id="wallmore'.$jxtc.'" class="wallmorebootstrap columns-'.$morecols.' rows-'.$rows.'">';
$moreareahtml .= '<div class="wallpage singlepage">';

for ($r=1;$r<=$rows;$r++) {
	if (empty($items)) { continue; }
	if ($rows == 1) { $rowclass = 'singlerow'; }	// Row class
	elseif ($r == 1) { $rowclass = 'firstrow'; }
	elseif ($r == $rows) { $rowclass = 'lastrow'; }
	else { $rowclass = 'centerrow'; }

	$moreareahtml .= '<div class="row-fluid '.$rowclass.' row-'.$r.'">';
	for ($c=1;$c<=$morecols;$c++) {
		$item = array_shift($items);
		if (!empty($item)) {
			$itemhtml = $moretemplate;
			require JModuleHelper::getLayoutPath($module->module, 'default_parse');
			if ($morecols == 1) { $colclass = 'singlecol'; } 	// Col class
			elseif ($c == 1) { $colclass = 'firstcol'; }
			elseif ($c == $morecols) { $colclass = 'lastcol'; }
			else { $colclass = 'centercol'; }

			$moreareahtml .= '<div class="'.$spanClass.' '.$colclass.' col-'.$c.'" >'.$itemhtml.'</div>';
			$index++;
		}
	}
	$moreareahtml .='</div>';
}

$moreareahtml .='</div>';
$moreareahtml .='</div>';

$modulehtml = str_replace('{morearea}', $moreareahtml, $modulehtml);

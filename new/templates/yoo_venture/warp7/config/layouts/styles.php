<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// theme, config & styles
$data['cookie']  = $this['config']['cookie'];
$data['baseurl'] = $this['path']->url('theme:', false);
$data['config']  = $this['path']->url('less:customizer.json');
$data['styles']  = array('default' => '');

// less files
$filter  = $this['assetfilter']->create(array('CssImportResolver', 'CssRewriteUrl'));
foreach ($this['config']['less'] as $target => $source) {
    $content = $this['asset']->createFile($source)->getContent($filter);
    $data['less'][] = array('source' => $content, 'target' => $target) ;
}

// less styles
if ($path = $this['path']->path('less:styles')) {
    foreach (glob("$path/*.less") as $file) {
        $data['styles'][basename($file, '.less')] = file_get_contents($file);
    }
}

echo json_encode($data);
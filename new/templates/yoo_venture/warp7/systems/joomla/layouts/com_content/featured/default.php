<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
<div class="page-header"><h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1></div>
<?php endif; ?>

<?php

// init vars
$articles = '';

// leading articles
$leading = (count($this->intro_items)) ? 'tm-leading-article' : '';
$articles  .= '<div class="uk-grid uk-grid-gutter '.$leading.'"><div class="uk-width-100">';
foreach ($this->lead_items as $item) {
	$this->item = $item;
	$articles  .= $this->loadTemplate('item');
}
$articles  .= '</div></div>';

// intro articles
$columns = array();
$i       = 0;

foreach ($this->intro_items as $item) {
	$column = $i++ % $this->params->get('num_columns', 2);

	if (!isset($columns[$column])) {
		$columns[$column] = '';
	}

	$this->item = $item;
	$columns[$column] .= $this->loadTemplate('item');
}

// render intro columns
if ($count = count($columns)) {
	$articles  .= '<div class="uk-grid uk-grid-gutter" data-uk="grid-match">';
	for ($i = 0; $i < $count; $i++) {
		$articles .= '<div class="uk-width-'.intval(100 / $count).'">'.$columns[$i].'</div>';
	}
	$articles  .= '</div>';
}

if ($articles) echo $articles;

?>

<?php if (!empty($this->link_items)) : ?>
<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h3>
<ul class="uk-list">
	<?php foreach ($this->link_items as &$item) : ?>
	<li><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>"><?php echo $item->title; ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
<?php echo $this->pagination->getPagesLinks(); ?>
<?php endif; ?>
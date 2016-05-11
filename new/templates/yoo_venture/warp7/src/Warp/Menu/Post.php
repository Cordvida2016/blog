<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Menu;

/**
 * Post menu renderer.
 */
class Post
{
    /**
     * Process menu
     *
     * @param  object $module
     * @param  object $element
     * @return object
     */
    public function process($module, $element)
    {
        foreach ($element->find('span') as $span) {

            if($type = $span->attr("data-type")) {

                if($type=="separator") {
                    $span->parent()->addClass("uk-nav-divider");
                    $span->parent()->removeChild($span);
                } else {
                    $span->parent()->addClass("uk-nav-header");
                    $span->replaceWith($span->text());
                }
            }
        }

        foreach($element->first("ul:first")->addClass($module->nav_settings["modifier"])->find('ul.level3') as $ul) {
            $ul->attr("class", "uk-nav-sub");
        }

        foreach ($element->find('li') as $li) {
            $li->removeAttr('data-id')->removeAttr('data-menu-active')->removeAttr('data-menu-columns')->removeAttr('data-menu-columnwidth')->removeAttr('data-menu-icon')->removeAttr('data-menu-image');
            $li->removeClass("level1")
               ->removeClass("level2")
               ->removeClass("level3")
               ->removeClass("level4")
            ->parent()
               ->removeClass("level1")
               ->removeClass("level2")
               ->removeClass("level3")
               ->removeClass("level4");
        }

        return $element;
    }
}

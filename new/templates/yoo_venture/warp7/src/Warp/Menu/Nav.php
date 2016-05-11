<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

namespace Warp\Menu;

/**
 * Nav menu renderer.
 */
class Nav
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

        $ul = $element->first('ul:first')->attr('class', 'uk-nav');

        if($module->nav_settings["accordion"]) {

            $ul->addClass("uk-nav-parent-icon")->addClass("uk-nav-side")->attr("data-uk", "nav");

            foreach($ul->find("ul.level2") as $list) {

                if ($list->prev()->tag() != 'a') {
                    $list->prev()->replaceWith('<a href="#">'.$list->prev()->text().'</a>');
                }

                $list->addClass("uk-nav-sub");
            }
        } else {

            foreach($ul->find("ul.level2") as $list) {
                $list->addClass("uk-nav-sub");
            }
        }


        if($module->position=="offcanvas") {

            foreach($ul->find("span[data-type]") as $span) {
                $li   = $span->parent();
                $list = $li->parent();

                if (!$list->hasClass('level1') && $span->attr("data-type")) {
                    $list->removeChild($li);
                }
            }
        }

        return $element;
    }
}
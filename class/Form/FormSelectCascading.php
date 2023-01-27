<?php

namespace XoopsModules\Wgsimpleacc\Form;

/**
 * Cascading XOOPS form select
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * wgSimpleAcc module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgsimpleacc
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsFormSelect;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Create cascading form select
 */
class FormSelectCascading extends \XoopsFormSelect
{

    /* https://github.com/geekonjava/FilterSelect */
    /**
     * custom option array of select
     * first select needs:
     * - id: id of option
     * - text: Text of select
     *
     * second select needs:
     * - id: id of option
     * - text: Text of select
     * - rel: id of option of first select
     * - init: initial value of first select
     *  => combination 'id' 'rel' should be unique
     * @var array
     */
    private $custom_options;

    /**
     * cascade type
     * 1 = source select
     * 2 = target select
     *
     * @var int
     */
    private $type;


    /**
     * create HTML to output the select field
     *
     * @return string
     */
    public function render()
    {
        $ele_name    = $this->getName();
        $ele_title   = $this->getTitle();
        $ele_value   = $this->getValue();
        $ele_options = $this->getCustomOptions();
        $ele_type    = $this->getType();

        $ret = '<select class="form-control';
        if (1 == $ele_type) {
            $ret .= ' firstList selectFilter" data-target="secondList"';
        } else {
            $ret .= ' secondList"';
        }
        $ret .= '" size="' . $this->getSize() . '"' . $this->getExtra();
        if ($this->isMultiple() != false) {
            $ret .= ' name="' . $ele_name . '[]" id="' . $ele_name . '" title="' . $ele_title
                . '" multiple="multiple">';
        } else {
            $ret .= ' name="' . $ele_name . '" id="' . $ele_name . '" title="' . $ele_title . '">';
        }
        foreach ($ele_options as $ele_option) {
            $ret .= '<option value="' . htmlspecialchars($ele_option['id'], ENT_QUOTES) . '"';
            if (count($ele_value) > 0 && in_array($ele_option['id'], $ele_value) && ((int)$ele_option['init'] === (int)$ele_option['rel'])) {
                $ret .= ' selected';
            }
            if (1 === (int)$ele_type) {
                $ret .= ' data-ref="all' . $ele_option['id'] . '"';
            }
            if (2 === (int)$ele_type) {
                $ret .= ' data-belong="all' . $ele_option['rel'] . '"';
            }
            if ((int)$ele_option['init'] !== (int)$ele_option['rel']) {
                $ret .= ' hidden';
            }
            $ret .= '>' . $ele_option['text'] . '</option>';
        }
        $ret .= '</select>';

        if (1 === (int)$ele_type) {
            $ret .= '<script>
                    $(document).ready(function(){
                        $(".selectFilter").on("change",function(){
                            var e=$(this).data("target"),i=$(this).find(":selected").data("ref");$("select."+e).val("-1"),null==i?$("select."+e).find("option").each(function(){console.log("inside undefined"),$(this).removeAttr("disabled hidden")}):$("select."+e).find("option").each(function(){var e=$(this).data("belong"),t=$(this).val();i!=e&&-1!=t?($(this).prop("disabled",!0),$(this).prop("hidden",!0)):($(this).prop("disabled",!1),$(this).prop("hidden",!1))})});
                    });
                </script>';
        }
        return $ret;

    }

    /**
     * Set type of select
     *
     * @param int $value
     */
    public function setType($value) {
        $this->type = $value;
    }

    /**
     * Get type of select
     *
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set custom options of select
     *
     * @param array $value
     */
    public function setCustomOptions($value) {
        $this->custom_options = $value;
    }

    /**
     * Get custom options of select
     *
     * @param array $value
     */
    public function getCustomOptions() {
        return $this->custom_options;
    }

}

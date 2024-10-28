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

/** Example Code
 *
    // Get Theme Form
    \xoops_load('XoopsFormLoader');
    $form = new \XoopsThemeForm('My form for testing cascading select', 'formTest',  $_SERVER['REQUEST_URI'], 'post', true);
    $form->setExtra('enctype="multipart/form-data"');

    $myExampleTray1 = new XoopsFormElementTray('Example Tray 1');
    $mySelect1 = new XoopsModules\Wgsimpleacc\Form\FormSelectCascading('Caption Select 1', 'select1', '2', 15);
    $mySelect1->setType(1);
    $arrSelect1 = [
    ['id' => '1', 'text'=>'Sourceelement 1', 'rel'=> '0', 'init'=> '0'],
    ['id' => '2', 'text'=>'Sourceelement 2', 'rel'=> '0', 'init'=> '0'],
    ['id' => '3', 'text'=>'Sourceelement 3', 'rel'=> '0', 'init'=> '0'],
    ];
    $mySelect1->setCustomOptions($arrSelect1);
    $myExampleTray1->addElement($mySelect1);

    $mySelect2 = new XoopsModules\Wgsimpleacc\Form\FormSelectCascading('Caption Select 2', 'select2', '4', 15);
    $mySelect2->setType(2);
    $arrSelect2 = [
    ['id' => '1', 'text'=>'Targetelement 1, linked to Sourceelement 1', 'rel'=> '1', 'init'=> '2'],
    ['id' => '1', 'text'=>'Targetelement 1, linked to Sourceelement 2', 'rel'=> '2', 'init'=> '2'],
    ['id' => '1', 'text'=>'Targetelement 1, linked to Sourceelement 3', 'rel'=> '3', 'init'=> '2'],
    ['id' => '2', 'text'=>'Targetelement 2, linked to Sourceelement 1', 'rel'=> '1', 'init'=> '2'],
    ['id' => '3', 'text'=>'Targetelement 3, linked to Sourceelement 1', 'rel'=> '1', 'init'=> '2'],
    ['id' => '3', 'text'=>'Targetelement 3, linked to Sourceelement 3', 'rel'=> '3', 'init'=> '2'],
    ['id' => '4', 'text'=>'Targetelement 4, linked to Sourceelement 2', 'rel'=> '2', 'init'=> '2'],
    ['id' => '5', 'text'=>'Targetelement 5, linked to Sourceelement 2', 'rel'=> '2', 'init'=> '2'],
    ];
    $mySelect2->setCustomOptions($arrSelect2);
    $myExampleTray1->addElement($mySelect2);
    $form->addElement($myExampleTray1);
    $form->addElement(new \XoopsFormHidden('op', 'save'));
    $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
    $GLOBALS['xoopsTpl']->assign('form', $form->render());
 *
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
     * - text: text of option
     * - rel: 0
     * - init: 0
     *
     * second select needs:
     * - id: id of option
     * - text: text of option
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
            $ret .= ' firstList selectFilter" data-target="secondList" ';
        } else {
            $ret .= ' secondList" ';
        }
        $ret .= ' size="' . $this->getSize() . '"' . $this->getExtra();
        if ($this->isMultiple() != false) {
            $ret .= ' name="' . $ele_name . '[]" id="' . $ele_name . '" title="' . $ele_title
                . ' multiple="multiple">';
        } else {
            $ret .= ' name="' . $ele_name . '" id="' . $ele_name . '" title="' . $ele_title . '">';
        }
        foreach ($ele_options as $ele_option) {
            $ret .= '<option value="' . htmlspecialchars($ele_option['id'], ENT_QUOTES) . '"';
            if (count($ele_value) > 0 && in_array($ele_option['id'], $ele_value) && ((int)$ele_option['init'] === (int)$ele_option['rel'])) {
                $ret .= ' selected';
            }
            if (1 === (int)$ele_type) {
                $ret .= ' data-ref="' . $ele_option['id'] . '"';
            }
            if (2 === (int)$ele_type) {
                $ret .= ' data-belong="' . $ele_option['rel'] . '"';
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
     * @return array
     */
    public function getCustomOptions() {
        return $this->custom_options;
    }
}

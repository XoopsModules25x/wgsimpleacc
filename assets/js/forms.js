
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgSimpleAcc module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgsimpleacc
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

function presetTraField() {

    var vselected = $("input:radio[name=tra_template]:checked").val()

    xoopsGetElementById('tra_desc').value = xoopsGetElementById('ttpl_desc[' + vselected +  ']').value;
    xoopsGetElementById('tra_accid').value = xoopsGetElementById('ttpl_accid[' + vselected +  ']').value;
    xoopsGetElementById('tra_allid').value = xoopsGetElementById('ttpl_allid[' + vselected +  ']').value;
    xoopsGetElementById('tra_asid').value = xoopsGetElementById('ttpl_asid[' + vselected +  ']').value;
    xoopsGetElementById('tra_amountin').value = xoopsGetElementById('ttpl_amountin[' + vselected +  ']').value;
    xoopsGetElementById('tra_amountout').value = xoopsGetElementById('ttpl_amountout[' + vselected +  ']').value;

}
// ]]>
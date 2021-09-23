
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
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

function presetTraField() {

    var vselected = $("input:radio[name=tra_template]:checked").val();

    xoopsGetElementById('tra_desc').value = xoopsGetElementById('ttpl_desc[' + vselected +  ']').value;
    /*handle iframe if tinymce is used*/
    var tradescifr = document.getElementById('tra_desc_ifr');
    if (tradescifr !== null) {
        tradescifr.contentDocument.getElementById('tinymce').innerHTML = xoopsGetElementById('tra_desc').value;
    }
    xoopsGetElementById('tra_accid').value = xoopsGetElementById('ttpl_accid[' + vselected +  ']').value;
    xoopsGetElementById('tra_allid').value = xoopsGetElementById('ttpl_allid[' + vselected +  ']').value;
    xoopsGetElementById('tra_asid').value = xoopsGetElementById('ttpl_asid[' + vselected +  ']').value;
    xoopsGetElementById('tra_amount').value = xoopsGetElementById('ttpl_amount[' + vselected +  ']').value;
    xoopsGetElementById('tra_cliid').value = xoopsGetElementById('ttpl_cliid[' + vselected +  ']').value;
    xoopsGetElementById('tra_cliid').click();

    var y = document.getElementsByClassName('ui-autocomplete-input');
    var aNode = y[0];
    aNode.value = xoopsGetElementById('ttpl_client[' + vselected +  ']').value;

}

function presetBalType() {

    var vselected = $("input:radio[name=bal_type]:checked").val()

    xoopsGetElementById('bal_from').value = xoopsGetElementById('dateFrom[' + vselected +  ']').value;
    xoopsGetElementById('bal_to').value = xoopsGetElementById('dateTo[' + vselected +  ']').value;

}

<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmarticle module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

/**
 * Class XmarticleUtility
 */
class XmarticleUtility
{    
    public static function fieldTypes()
    {
        $types = array(
            'label'         => _MA_XMARTICLE_FIELDTYPE_LABEL,
            'vs_text'       => _MA_XMARTICLE_FIELDTYPE_VSTEXT,
            's_text'        => _MA_XMARTICLE_FIELDTYPE_STEXT,
            'm_text'        => _MA_XMARTICLE_FIELDTYPE_MTEXT,
            'l_text'        => _MA_XMARTICLE_FIELDTYPE_LTEXT,
            'text'          => _MA_XMARTICLE_FIELDTYPE_TEXT,
            'select'        => _MA_XMARTICLE_FIELDTYPE_SELECT,
            'select_multi'  => _MA_XMARTICLE_FIELDTYPE_SELECTMULTI,
            'radio_yn'      => _MA_XMARTICLE_FIELDTYPE_RADIOYN,
            'radio'         => _MA_XMARTICLE_FIELDTYPE_RADIO,
            'checkbox'      => _MA_XMARTICLE_FIELDTYPE_CHECKBOX,
            'number'        => _MA_XMARTICLE_FIELDTYPE_NUMBER);
        return $types;
    }
}

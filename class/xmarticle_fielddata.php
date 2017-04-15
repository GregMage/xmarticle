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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmarticle_fielddata
 */
class xmarticle_fielddata extends XoopsObject
{
    // constructor
    /**
     * xmarticle_fielddata constructor.
     */
    public function __construct()
    {
        $this->initVar('fielddata_id', XOBJ_DTYPE_INT, null);
		$this->initVar('fielddata_fid', XOBJ_DTYPE_INT, null);
		$this->initVar('fielddata_aid', XOBJ_DTYPE_INT, null);
        $this->initVar('fielddata_value1', XOBJ_DTYPE_TXTBOX, null);
        $this->initVar('fielddata_value2', XOBJ_DTYPE_TXTAREA);
		$this->initVar('fielddata_value3', XOBJ_DTYPE_TXTAREA);
        $this->initVar('fielddata_value4', XOBJ_DTYPE_OTHER, null, false);
    }

    /**
     * @return mixed
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }
}

/**
 * Class xmarticlexmarticle_fielddataHandler
 */
class xmarticlexmarticle_fielddataHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmarticlexmarticle_fielddataHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct(&$db)
    {
        parent::__construct($db, 'xmarticle_fielddata', 'xmarticle_fielddata', 'fielddata_id', 'fielddata_fid');
    }
}

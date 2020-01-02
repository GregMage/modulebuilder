<?php namespace XoopsModules\Tdmcreate;

use XoopsModules\Tdmcreate;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * tdmcreate module.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 *
 * @since           2.5.7
 *
 * @author          Txmod Xoops <webmaster@txmodxoops.org> - <http://www.txmodxoops.org/>
 *
 * @version         $Id: 1.91 fieldattributes.php 13027 2015-02-14 12:18:10Z timgno $
 */

 /**
*  @Class Fieldattributes
*  @extends \XoopsObject
*/

/**
 * Class Fieldattributes.
 */
class Fieldattributes extends \XoopsObject
{
    /**
    *  @public function constructor class
    *  @param null
    */

    public function __construct()
    {
        $this->initVar('fieldattribute_id', XOBJ_DTYPE_INT);
        $this->initVar('fieldattribute_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('fieldattribute_value', XOBJ_DTYPE_TXTBOX);
    }

    /**
    *  @static function getInstance
    *  @param null
     * @return Fieldattributes
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Get Values.
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesFieldattributes($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        // Values
        $ret['id'] = $this->getVar('fieldattribute_id');
        $ret['name'] = $this->getVar('fieldattribute_name');
        $ret['value'] = $this->getVar('fieldattribute_value');

        return $ret;
    }
}

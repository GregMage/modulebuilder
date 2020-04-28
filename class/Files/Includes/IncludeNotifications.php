<?php

namespace XoopsModules\Tdmcreate\Files\Includes;

use XoopsModules\Tdmcreate;
use XoopsModules\Tdmcreate\Files;

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
 * @since           2.5.0
 *
 * @author          Txmod Xoops http://www.txmodxoops.org
 *
 */

/**
 * Class IncludeNotifications.
 */
class IncludeNotifications extends Files\CreateFile
{
    /**
     * @public function constructor
     * @param null
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @static function getInstance
     * @param null
     * @return IncludeNotifications
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
     * @public function write
     * @param string $module
     * @param mixed  $tables
     * @param string $filename
     */
    public function write($module, $tables, $filename)
    {
        $this->setModule($module);
        $this->setTables($tables);
        $this->setFileName($filename);
    }

    /**
     * @static function getNotificationsFunction
     * @param string $moduleDirname
     *
     * @return string
     */
    public function getNotificationsFunction($moduleDirname)
    {
        $pc               = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc               = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $stuModuleDirname = mb_strtoupper($moduleDirname);
        $tables           = $this->getTables();
        $t      = "\t";
        $ret    = $pc->getPhpCodeCommentMultiLine(['comment' => 'callback functions','' => '', '@param  $category' => '', '@param  $item_id' => '', '@return' => 'array item|null']);
        $func   = $xc->getXcGetGlobal(['xoopsDB'], $t);
        $func   .= $pc->getPhpCodeBlankLine();
        $contIf = $pc->getPhpCodeDefine($stuModuleDirname . '_URL',"XOOPS_URL . '/modules/{$moduleDirname}'", $t . "\t");
        $func   .= $pc->getPhpCodeConditions("!defined('{$stuModuleDirname}_URL')", '','',$contIf, false, $t);
        $func   .= $pc->getPhpCodeBlankLine();

        $case[] = $xc->getXcEqualsOperator("\$item['name']", "''",'',$t . "\t\t");
        $case[] = $xc->getXcEqualsOperator("\$item['url'] ", "''",'',$t . "\t\t");
        $case[] = $this->getSimpleString('return $item;', $t . "\t\t");
        $cases  = [
            'global' => $case,
        ];
        $contentSwitch = $pc->getPhpCodeCaseSwitch($cases, false, false, $t . "\t");
        unset($case);

        foreach (array_keys($tables) as $i) {
            if (1 === (int)$tables[$i]->getVar('table_notifications')) {
                $tableName   = $tables[$i]->getVar('table_name');
                $fieldParent = false;
                $fields      = $this->getTableFields($tables[$i]->getVar('table_mid'), $tables[$i]->getVar('table_id'));
                foreach (array_keys($fields) as $f) {
                    $fieldName = $fields[$f]->getVar('field_name');
                    if ((0 == $f) && (1 == $tables[$i]->getVar('table_autoincrement'))) {
                        $fieldId = $fieldName;
                    }
                    if (1 == $fields[$f]->getVar('field_parent')) {
                        $fieldParent = $fieldName;
                    }
                    if (1 == $fields[$f]->getVar('field_main')) {
                        $fieldMain = $fieldName;
                    }
                }
                if (1 == $tables[$i]->getVar('table_single')) {
                    $tableSingle = 'single';
                } else {
                    $tableSingle = $tableName;
                }
                $case[] = $xc->getXcEqualsOperator('$sql         ', "'SELECT {$fieldMain} FROM ' . \$xoopsDB->prefix('{$moduleDirname}_{$tableName}') . ' WHERE {$fieldId} = '. \$item_id",'',$t . "\t\t");
                $case[] = $xc->getXcEqualsOperator('$result      ', '$xoopsDB->query($sql)','',$t . "\t\t");
                $case[] = $xc->getXcEqualsOperator('$result_array', '$xoopsDB->fetchArray($result)','',$t . "\t\t");
                $case[] = $xc->getXcEqualsOperator("\$item['name']", "\$result_array['{$fieldMain}']",'',$t . "\t\t");
                if ($fieldParent) {
                    $case[] = $xc->getXcEqualsOperator("\$item['url'] ", "{$stuModuleDirname}_URL . '/{$tableSingle}.php?{$fieldParent}=' . \$result_array['{$fieldParent}'] . '&amp;{$fieldId}=' . \$item_id",'',$t . "\t\t");
                } else {
                    $case[] = $xc->getXcEqualsOperator("\$item['url'] ", "{$stuModuleDirname}_URL . '/{$tableName}.php?{$fieldId}=' . \$item_id",'',$t . "\t\t");
                }

                $case[] = $this->getSimpleString('return $item;', $t . "\t\t");
                $cases  = [
                    $tableName => $case,
                ];
                $contentSwitch .= $pc->getPhpCodeCaseSwitch($cases, false, false, $t . "\t");
                unset($case);
            }
        }

        $func .= $pc->getPhpCodeSwitch('category', $contentSwitch, $t);
        $func .= $this->getSimpleString('return null;', $t );
        $ret  .= $pc->getPhpCodeFunction("{$moduleDirname}_notify_iteminfo", '$category, $item_id', $func);

        return $ret;
    }

    /**
     * @public function render
     * @param null
     * @return bool|string
     */
    public function render()
    {
        $module        = $this->getModule();
        $filename      = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');
        $content       = $this->getHeaderFilesComments($module, $filename);
        $content       .= $this->getNotificationsFunction($moduleDirname);

        $this->create($moduleDirname, 'include', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}

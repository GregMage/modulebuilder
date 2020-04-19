<?php

namespace XoopsModules\Tdmcreate\Files\Classes;

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
 * tc module.
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
 * Class ClassFiles.
 */
class ClassFiles extends Files\CreateFile
{
    /**
     * @public function constructor
     *
     * @param null
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @static function getInstance
     *
     * @param null
     *
     * @return ClassFiles
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
     *
     * @param string $module
     * @param string $table
     * @param mixed  $tables
     * @param        $filename
     */
    public function write($module, $table, $tables, $filename)
    {
        $this->setModule($module);
        $this->setTable($table);
        $this->setTables($tables);
        $this->setFileName($filename);
    }

    /**
     * @private function getInitVar
     *
     * @param string $fieldName
     * @param string $type
     *
     * @return string
     */
    private function getInitVar($fieldName, $type = 'INT')
    {
        $cc = Tdmcreate\Files\Classes\ClassXoopsCode::getInstance();

        return $cc->getClassInitVar($fieldName, $type);
    }

    /**
     * @private function getInitVars
     *
     * @param array $fields
     *
     * @return string
     */
    private function getInitVars($fields)
    {
        $ret = '';
        // Creation of the initVar functions list
        foreach (array_keys($fields) as $f) {
            $fieldName = $fields[$f]->getVar('field_name');
            $fieldType = $fields[$f]->getVar('field_type');
            switch ($fieldType) {
                case 2:
                case 3:
                case 4:
                case 5:
                    $ret .= $this->getInitVar($fieldName, 'INT');
                    break;
                case 6:
                    $ret .= $this->getInitVar($fieldName, 'FLOAT');
                    break;
                case 7:
                case 8:
                    $ret .= $this->getInitVar($fieldName, 'DECIMAL');
                    break;
                case 10:
                    $ret .= $this->getInitVar($fieldName, 'ENUM');
                    break;
                case 11:
                    $ret .= $this->getInitVar($fieldName, 'EMAIL');
                    break;
                case 12:
                    $ret .= $this->getInitVar($fieldName, 'URL');
                    break;
                case 13:
                case 14:
                    $ret .= $this->getInitVar($fieldName, 'TXTBOX');
                    break;
                case 15:
                case 16:
                case 17:
                case 18:
                    $ret .= $this->getInitVar($fieldName, 'TXTAREA');
                    break;
                case 19:
                case 20:
                case 21:
                case 22:
                case 23:
                    $ret .= $this->getInitVar($fieldName, 'LTIME');
                    break;
            }
        }

        return $ret;
    }

    /**
     * @private  function getClassObject
     * @param $module
     * @param $table
     * @param $fields
     * @return string
     */
    private function getClassObject($module, $table, $fields)
    {
        $tc               = Tdmcreate\Helper::getInstance();
        $pc               = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc               = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $moduleDirname    = $module->getVar('mod_dirname');
        $tableName        = $table->getVar('table_name');
        $ucfTableName     = ucfirst($tableName);
        $ret              = $pc->getPhpCodeDefined();
        $ret              .= $pc->getPhpCodeCommentMultiLine(['Class Object' => $ucfTableName]);
        $cCl              = '';

        $fieldInForm      = [];
        $fieldElementId   = [];
        $optionsFieldName = [];
        $fieldId          = null;
        foreach (array_keys($fields) as $f) {
            $fieldName        = $fields[$f]->getVar('field_name');
            $fieldElement     = $fields[$f]->getVar('field_element');
            $fieldInForm[]    = $fields[$f]->getVar('field_inform');
            $fieldElements    = $tc->getHandler('fieldelements')->get($fieldElement);
            $fieldElementId[] = $fieldElements->getVar('fieldelement_id');
            $rpFieldName      = $this->getRightString($fieldName);
                        if (in_array(5, $fieldElementId)) {
                if (count($rpFieldName) % 5) {
                    $optionsFieldName[] = "'" . $rpFieldName . "'";
                } else {
                    $optionsFieldName[] = "'" . $rpFieldName . "'\n";
                }
            }
            if ((0 == $f) && (1 == $table->getVar('table_autoincrement'))) {
                $fieldId = $fieldName;
            }
        }
        if (in_array(5, $fieldElementId) > 1) {
            $cCl             .= $pc->getPhpCodeCommentMultiLine(['Options' => '']);
            $options         = $pc->getPhpCodeArray('', $optionsFieldName, true);
            $cCl             .= $pc->getPhpCodeVariableClass('private', 'options', $options);
        }
        unset($optionsFieldName);

        $cCl              .= $pc->getPhpCodeCommentMultiLine(['Constructor' => '', '' => '', '@param' => 'null'], "\t");
        $constr           = $this->getInitVars($fields);
        $cCl              .= $pc->getPhpCodeFunction('__construct', '', $constr, 'public ', false, "\t");
        $arrayGetInstance = ['@static function' => '&getInstance', '' => '', '@param' => 'null'];
        $cCl              .= $pc->getPhpCodeCommentMultiLine($arrayGetInstance, "\t");
        $getInstance      = $pc->getPhpCodeVariableClass('static', 'instance', 'false', "\t\t");
        $instance         = $xc->getXcEqualsOperator('$instance', 'new self()', null, false, "\t\t\t");
        $getInstance      .= $pc->getPhpCodeConditions('!$instance', '', '', $instance, false, "\t\t");
        $cCl              .= $pc->getPhpCodeFunction('getInstance', '', $getInstance, 'public static ', false, "\t");

        $cCl .= $this->getNewInsertId($table);
        $cCl .= $this->getFunctionForm($module, $table, $fieldId, $fieldInForm);
        $cCl .= $this->getValuesInObject($moduleDirname, $table, $fields);
        $cCl .= $this->getToArrayInObject($table);

        if (in_array(5, $fieldElementId) > 1) {
            $cCl .= $this->getOptionsCheck($table);
        }
        unset($fieldElementId);

        $ret .= $pc->getPhpCodeClass($ucfTableName, $cCl, '\XoopsObject');

        return $ret;
    }

    /**
     * @private function getNewInsertId
     *
     * @param $table
     *
     * @return string
     */
    private function getNewInsertId($table)
    {
        $pc            = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc            = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $tableName     = $table->getVar('table_name');
        $ucfTableName  = ucfirst($tableName);
        $ret           = $pc->getPhpCodeCommentMultiLine(['The new inserted' => '$Id', '@return' => 'inserted id'], "\t");
        $getInsertedId = $xc->getXcEqualsOperator('$newInsertedId', "\$GLOBALS['xoopsDB']->getInsertId()", null, false, "\t\t");
        $getInsertedId .= $this->getSimpleString('return $newInsertedId;', "\t\t");

        $ret .= $pc->getPhpCodeFunction('getNewInsertedId' . $ucfTableName, '', $getInsertedId, 'public ', false, "\t");

        return $ret;
    }

    /**
     * @private function getFunctionForm
     *
     * @param string $module
     * @param string $table
     *
     * @param        $fieldId
     * @param        $fieldInForm
     * @return string
     */
    private function getFunctionForm($module, $table, $fieldId, $fieldInForm)
    {
        $pc               = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc               = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $cc               = Tdmcreate\Files\Classes\ClassXoopsCode::getInstance();
        $fe               = ClassFormElements::getInstance();
        $moduleDirname    = $module->getVar('mod_dirname');
        $tableName        = $table->getVar('table_name');
        $tableSoleName    = $table->getVar('table_solename');
        $tableCategory    = $table->getVar('table_category');
        $ucfTableName     = ucfirst($tableName);
        $stuTableSoleName = mb_strtoupper($tableSoleName);
        $language         = $this->getLanguage($moduleDirname, 'AM');
        $fe->initForm($module, $table);
        $ret              = $pc->getPhpCodeCommentMultiLine(['@public function' => 'getForm', '@param bool' => '$action', '@return' => 'XoopsThemeForm'], "\t");
        $action           = $xc->getXcEqualsOperator('$action', "\$_SERVER['REQUEST_URI']", null, false, "\t\t\t");
        $ucfModuleDirname = ucfirst($moduleDirname);
        $getForm          = $xc->getXcGetInstance('helper', "\XoopsModules\\{$ucfModuleDirname}\Helper", "\t\t");
        //$getForm .= $pc->getPhpCodeConditions('$action', ' === ', 'false', $action, false, "\t\t");
        $getForm .= $pc->getPhpCodeConditions('false', ' === ', '$action', $action, false, "\t\t");
        $xUser   = $pc->getPhpCodeGlobals('xoopsUser');
        $xModule = $pc->getPhpCodeGlobals('xoopsModule');
        $permString = 'upload_groups';
        if (1 != $tableCategory/* && (1 == $tablePermissions)*/) {
            $getForm          .= $pc->getPhpCodeCommentLine('Permissions for', 'uploader', "\t\t");
            $getForm          .= $xc->getXcEqualsOperator('$grouppermHandler', "xoops_getHandler('groupperm')", null, true, "\t\t");
            $getForm          .= $pc->getPhpCodeTernaryOperator('groups', 'is_object(' . $xUser . ')', $xUser . '->getGroups()', 'XOOPS_GROUP_ANONYMOUS', "\t\t");
            $checkRight       = $xc->getXcCheckRight('$grouppermHandler', $permString, 32, '$groups', $xModule . '->getVar(\'mid\')', true);
            $ternaryOperator  = $pc->getPhpCodeTernaryOperator('permissionUpload', $checkRight, 'true', 'false', "\t\t\t");
            $permissionUpload = $xc->getXcEqualsOperator('$permissionUpload', 'true', null, false, "\t\t\t\t");
            $ternOperator     = $pc->getPhpCodeRemoveCarriageReturn($ternaryOperator, '', "\r");
            $if               = $pc->getPhpCodeConditions('!' . $xUser . '->isAdmin(' . $xModule . '->mid())', '', '', "\t" . $ternaryOperator, $permissionUpload, "\t\t\t");
            $getForm          .= $pc->getPhpCodeConditions($xUser, '', '', $if, $ternOperator, "\t\t");
        }
        $getForm .= $pc->getPhpCodeCommentLine('Title', '', "\t\t");
        $getForm .= $pc->getPhpCodeTernaryOperator('title', '$this->isNew()', "sprintf({$language}{$stuTableSoleName}_ADD)", "sprintf({$language}{$stuTableSoleName}_EDIT)", "\t\t");
        $getForm .= $pc->getPhpCodeCommentLine('Get Theme', 'Form', "\t\t");
        $getForm .= $xc->getXcLoad('XoopsFormLoader', "\t\t");
        $getForm .= $cc->getClassXoopsThemeForm('form', 'title', 'form', 'action', 'post');
        $getForm .= $cc->getClassSetExtra('form', "'enctype=\"multipart/form-data\"'");
        $getForm .= $fe->renderElements();

        if (in_array(1, $fieldInForm)) {
            if (1 == $table->getVar('table_permissions')) {
                $getForm .= $this->getPermissionsInForm($moduleDirname, $fieldId, $tableName);
            }
        }
        $getForm .= $pc->getPhpCodeCommentLine('To Save', '', "\t\t");
        //$hiddenSave = $cc->getClassXoopsFormHidden('', "'op'", "'save'", true, false);
        $getForm .= $cc->getClassAddElement('form', "new \XoopsFormHidden('op', 'save')");
        //$buttonSend = $cc->getClassXoopsFormButton('', '', 'submit', '_SUBMIT', 'submit', true);
        $getForm .= $cc->getClassAddElement('form', "new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false)");
        $getForm .= $this->getSimpleString('return $form;', "\t\t");

        $ret .= $pc->getPhpCodeFunction('getForm' . $ucfTableName, '$action = false', $getForm, 'public ', false, "\t");

        return $ret;
    }

    /**
     * @private function getPermissionsInForm
     *
     * @param string $moduleDirname
     * @param string $fieldId
     *
     * @param $tableName
     * @return string
     */
    private function getPermissionsInForm($moduleDirname, $fieldId, $tableName)
    {
        $pc                = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc                = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $cc                = Tdmcreate\Files\Classes\ClassXoopsCode::getInstance();
        $permissionApprove = $this->getLanguage($moduleDirname, 'AM', 'PERMISSIONS_APPROVE');
        $permissionSubmit  = $this->getLanguage($moduleDirname, 'AM', 'PERMISSIONS_SUBMIT');
        $permissionView    = $this->getLanguage($moduleDirname, 'AM', 'PERMISSIONS_VIEW');
        $ret               = $pc->getPhpCodeCommentLine('Permissions', '', "\t\t");
        $ret               .= $xc->getXcEqualsOperator('$memberHandler', "xoops_getHandler('member')", null, false, "\t\t");
        $ret               .= $xc->getXcEqualsOperator('$groupList', '$memberHandler->getGroupList()', null, false, "\t\t");
        $ret               .= $xc->getXcEqualsOperator('$grouppermHandler', "xoops_getHandler('groupperm')", null, false, "\t\t");
        $ret               .= $pc->getPhpCodeArrayType('fullList', 'keys', 'groupList', null, false, "\t\t");
        $fId               = $xc->getXcGetVar('', 'this', $fieldId, true);
        $mId               = $xc->getXcGetVar('', "GLOBALS['xoopsModule']", 'mid', true);
        $ifGroups          = $xc->getXcGetGroupIds('groupsIdsApprove', 'grouppermHandler', "'{$moduleDirname}_approve_{$tableName}'", $fId, $mId, "\t\t\t");
        $ifGroups          .= $pc->getPhpCodeArrayType('groupsIdsApprove', 'values', 'groupsIdsApprove', null, false, "\t\t\t");
        $ifGroups          .= $cc->getClassXoopsFormCheckBox('groupsCanApproveCheckbox', $permissionApprove, "groups_approve_{$tableName}[]", '$groupsIdsApprove', false, "\t\t\t");
        $ifGroups          .= $xc->getXcGetGroupIds('groupsIdsSubmit', 'grouppermHandler', "'{$moduleDirname}_submit_{$tableName}'", $fId, $mId, "\t\t\t");
        $ifGroups          .= $pc->getPhpCodeArrayType('groupsIdsSubmit', 'values', 'groupsIdsSubmit', null, false, "\t\t\t");
        $ifGroups          .= $cc->getClassXoopsFormCheckBox('groupsCanSubmitCheckbox', $permissionSubmit, "groups_submit_{$tableName}[]", '$groupsIdsSubmit', false, "\t\t\t");
        $ifGroups          .= $xc->getXcGetGroupIds('groupsIdsView', 'grouppermHandler', "'{$moduleDirname}_view_{$tableName}'", $fId, $mId, "\t\t\t");
        $ifGroups          .= $pc->getPhpCodeArrayType('groupsIdsView', 'values', 'groupsIdsView', null, false, "\t\t\t");
        $ifGroups          .= $cc->getClassXoopsFormCheckBox('groupsCanViewCheckbox', $permissionView, "groups_view_{$tableName}[]", '$groupsIdsView', false, "\t\t\t");

        $else = $cc->getClassXoopsFormCheckBox('groupsCanApproveCheckbox', $permissionApprove, "groups_approve_{$tableName}[]", '$fullList', false, "\t\t\t");
        $else .= $cc->getClassXoopsFormCheckBox('groupsCanSubmitCheckbox', $permissionSubmit, "groups_submit_{$tableName}[]", '$fullList', false, "\t\t\t");
        $else .= $cc->getClassXoopsFormCheckBox('groupsCanViewCheckbox', $permissionView, "groups_view_{$tableName}[]", '$fullList', false, "\t\t\t");

        $ret .= $pc->getPhpCodeConditions('!$this->isNew()', null, null, $ifGroups, $else, "\t\t");
        $ret .= $pc->getPhpCodeCommentLine('To Approve', '', "\t\t");
        $ret .= $cc->getClassAddOptionArray('groupsCanApproveCheckbox', '$groupList');
        $ret .= $cc->getClassAddElement('form', '$groupsCanApproveCheckbox');
        $ret .= $pc->getPhpCodeCommentLine('To Submit', '', "\t\t");
        $ret .= $cc->getClassAddOptionArray('groupsCanSubmitCheckbox', '$groupList');
        $ret .= $cc->getClassAddElement('form', '$groupsCanSubmitCheckbox');
        $ret .= $pc->getPhpCodeCommentLine('To View', '', "\t\t");
        $ret .= $cc->getClassAddOptionArray('groupsCanViewCheckbox', '$groupList');
        $ret .= $cc->getClassAddElement('form', '$groupsCanViewCheckbox');

        return $ret;
    }

    /**
     * @private  function getValuesInObject
     *
     * @param $moduleDirname
     * @param $table
     * @param $fields
     * @return string
     * @internal param $null
     */
    private function getValuesInObject($moduleDirname, $table, $fields)
    {
        $tc               = Tdmcreate\Helper::getInstance();
        $pc               = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc               = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $ucfTableName     = ucfirst($table->getVar('table_name'));
        $ret              = $pc->getPhpCodeCommentMultiLine(['Get' => 'Values', '@param null $keys' => '', '@param null $format' => '', '@param null$maxDepth' => '', '@return' => 'array'], "\t");
        $ucfModuleDirname = ucfirst($moduleDirname);
        $getValues        = $xc->getXcGetInstance('helper', "\XoopsModules\\{$ucfModuleDirname}\Helper", "\t\t");
        $getValues        .= $xc->getXcEqualsOperator('$ret', '$this->getValues($keys, $format, $maxDepth)', null, false, "\t\t");
        $fieldMainTopic   = null;
        foreach (array_keys($fields) as $f) {
            $fieldName    = $fields[$f]->getVar('field_name');
            $fieldElement = $fields[$f]->getVar('field_element');
            $rpFieldName  = $this->getRightString($fieldName);
            switch ($fieldElement) {
                case 3:
                case 4:
                    $getValues .= $pc->getPhpCodeStripTags("ret['{$rpFieldName}']", "\$this->getVar('{$fieldName}')", false, "\t\t");
                    break;
                case 6:
                    $getValues .= $xc->getXcGetVar("ret['{$rpFieldName}']", 'this', $fieldName, false, "\t\t");
                    $getValues .= $xc->getXcEqualsOperator("\$ret['{$rpFieldName}_text']", "(int)\$this->getVar('{$fieldName}') > 0 ? _YES : _NO", false, '',"\t\t");
                    break;
                case 8:
                    $getValues .= $xc->getXcUnameFromId("ret['{$rpFieldName}']", "\$this->getVar('{$fieldName}')", "\t\t");
                    break;
                case 15:
                    $getValues .= $xc->getXcFormatTimeStamp("ret['{$rpFieldName}']", "\$this->getVar('{$fieldName}')", 's', "\t\t");
                    break;
                default:
                    if ($fieldElement > 16) {
                        $fieldElements    = $tc->getHandler('fieldelements')->get($fieldElement);
                        $fieldElementMid  = $fieldElements->getVar('fieldelement_mid');
                        $fieldElementTid  = $fieldElements->getVar('fieldelement_tid');
                        $fieldElementName = $fieldElements->getVar('fieldelement_name');
                        $fieldNameDesc    = mb_substr($fieldElementName, mb_strrpos($fieldElementName, ':'), mb_strlen($fieldElementName));
                        $topicTableName   = str_replace(': ', '', mb_strtolower($fieldNameDesc));
                        $fieldsTopics     = $this->getTableFields($fieldElementMid, $fieldElementTid);
                        foreach (array_keys($fieldsTopics) as $g) {
                            $fieldNameTopic = $fieldsTopics[$g]->getVar('field_name');
                            if (1 == $fieldsTopics[$g]->getVar('field_main')) {
                                $fieldMainTopic = $fieldNameTopic;
                            }
                        }
                        $getHandlerVar = "\$helper->getHandler('{$topicTableName}')";
                        $getValues     .= $xc->getXcEqualsOperator("\${$topicTableName}", $getHandlerVar, null, false, "\t\t");
                        $getTopicTable = "\${$topicTableName}->get(\$this->getVar('{$fieldName}'))";
                        $getValues     .= $xc->getXcEqualsOperator("\${$topicTableName}Obj", $getTopicTable, null, false, "\t\t");
                        $fMainTopic    = "\${$topicTableName}Obj->getVar('{$fieldMainTopic}')";
                        $getValues     .= $xc->getXcEqualsOperator("\$ret['{$rpFieldName}']", $fMainTopic, null, false, "\t\t");
                    } else {
                        $getValues .= $xc->getXcGetVar("ret['{$rpFieldName}']", 'this', $fieldName, false, "\t\t");
                    }
                    break;
            }
        }
        $getValues .= $this->getSimpleString('return $ret;', "\t\t");

        $ret .= $pc->getPhpCodeFunction('getValues' . $ucfTableName, '$keys = null, $format = null, $maxDepth = null', $getValues, 'public ', false, "\t");

        return $ret;
    }

    /**
     * @private function getToArrayInObject
     *
     * @param $table
     *
     * @return string
     */
    private function getToArrayInObject($table)
    {
        $pc           = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc           = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $tableName    = $table->getVar('table_name');
        $ucfTableName = ucfirst($tableName);
        $multiLineCom = ['Returns an array representation' => 'of the object', '' => '', '@return' => 'array'];
        $ret          = $pc->getPhpCodeCommentMultiLine($multiLineCom, "\t");

        $getToArray = $pc->getPhpCodeArray('ret', [], false, "\t\t");
        $getToArray .= $xc->getXcEqualsOperator('$vars', '$this->getVars()', null, false, "\t\t");
        $foreach    = $xc->getXcGetVar('ret[$var]', 'this', '"{$var}"', false, "\t\t\t");
        $getToArray .= $pc->getPhpCodeForeach('vars', true, false, 'var', $foreach, "\t\t");
        $getToArray .= $this->getSimpleString('return $ret;', "\t\t");

        $ret .= $pc->getPhpCodeFunction('toArray' . $ucfTableName, '', $getToArray, 'public ', false, "\t");

        return $ret;
    }

    /**
     * @private function getOptionsCheck
     *
     * @param $table
     *
     * @return string
     */
    private function getOptionsCheck($table)
    {
        $tc           = Tdmcreate\Helper::getInstance();
        $pc           = Tdmcreate\Files\CreatePhpCode::getInstance();
        $tableName    = $table->getVar('table_name');
        $ucfTableName = ucfirst($tableName);
        $ret          = $pc->getPhpCodeCommentMultiLine(['Get' => 'Options'], "\t");
        $getOptions   = $pc->getPhpCodeArray('ret', [], false, "\t");

        $fields = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));
        foreach (array_keys($fields) as $f) {
            $fieldName    = $fields[$f]->getVar('field_name');
            $fieldElement = $fields[$f]->getVar('field_element');

            $fieldElements  = $tc->getHandler('fieldelements')->get($fieldElement);
            $fieldElementId = $fieldElements->getVar('fieldelement_id');
            $rpFieldName    = $this->getRightString($fieldName);
            if (5 == $fieldElementId) {
                $arrayPush  = $pc->getPhpCodeArrayType('ret', 'push', "'{$rpFieldName}'", null, false, "\t\t\t");
                $getOptions .= $pc->getPhpCodeConditions(1, ' == ', "\$this->getVar('{$fieldName}')", $arrayPush, false, "\t\t");
            }
        }

        $getOptions .= $this->getSimpleString('return $ret;', "\t\t");

        $ret .= $pc->getPhpCodeFunction('getOptions' . $ucfTableName, '', $getOptions, 'public ', false, "\t");

        return $ret;
    }

    /**
     * @public function render
     * @param null
     *
     * @return bool|string
     */
    public function render()
    {
        $pc             = Tdmcreate\Files\CreatePhpCode::getInstance();
        $module         = $this->getModule();
        $table          = $this->getTable();
        $filename       = $this->getFileName();
        $moduleDirname  = $module->getVar('mod_dirname');
        $fields         = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));

        $namespace = $pc->getPhpCodeNamespace(['XoopsModules', $moduleDirname]);
        $content   = $this->getHeaderFilesComments($module, $filename, null, $namespace);
        $content   .= $pc->getPhpCodeUseNamespace(['XoopsModules', $moduleDirname]);
        $content   .= $this->getClassObject($module, $table, $fields);

        $this->create($moduleDirname, 'class', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}

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
 * tdmcreatereate module.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 *
 * @since           2.5.7
 *
 * @author          Txmod Xoops <webmaster@txmodxoops.org> - <http://www.txmodxoops.org/>
 *
 * @version         $Id: 1.91 fields.php 12258 2014-01-02 09:33:29Z timgno $
 */
//include __DIR__.'/autoload.php';

/**
 * Class Fields.
 */
class Fields extends \XoopsObject
{
    /**
     *  @public function constructor class
     *
     *  @param null
     */
    public function __construct()
    {
        $this->initVar('field_id', XOBJ_DTYPE_INT);
        $this->initVar('field_mid', XOBJ_DTYPE_INT);
        $this->initVar('field_tid', XOBJ_DTYPE_INT);
        $this->initVar('field_order', XOBJ_DTYPE_INT);
        $this->initVar('field_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_type', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_value', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_attribute', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_null', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_default', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_key', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_element', XOBJ_DTYPE_TXTBOX);
        $this->initVar('field_parent', XOBJ_DTYPE_INT);
        $this->initVar('field_admin', XOBJ_DTYPE_INT);
        $this->initVar('field_inlist', XOBJ_DTYPE_INT);
        $this->initVar('field_inform', XOBJ_DTYPE_INT);
        $this->initVar('field_user', XOBJ_DTYPE_INT);
        $this->initVar('field_thead', XOBJ_DTYPE_INT);
        $this->initVar('field_tbody', XOBJ_DTYPE_INT);
        $this->initVar('field_tfoot', XOBJ_DTYPE_INT);
        $this->initVar('field_block', XOBJ_DTYPE_INT);
        $this->initVar('field_main', XOBJ_DTYPE_INT);
        $this->initVar('field_search', XOBJ_DTYPE_INT);
        $this->initVar('field_required', XOBJ_DTYPE_INT);
    }

    /**
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        $arg = isset($args[0]) ? $args[0] : null;

        return $this->getVar($method, $arg);
    }

    /**
     * @static function getInstance
     *
     * @return Fields
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
     * @private function getHeaderForm
     *
     * @param bool $action
     * @return Tdmcreate\Form\ThemeForm
     */
    private function getHeaderForm($action = false)
    {
        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        $isNew = $this->isNew();
        $title = $isNew ? sprintf(_AM_TDMCREATE_FIELDS_NEW) : sprintf(_AM_TDMCREATE_FIELDS_EDIT);

        $form = new Tdmcreate\Form\ThemeForm(null, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // New Object HtmlTable
        $form->addElement(new Tdmcreate\Html\FormLabel('<table cellspacing="1" class="outer width100">'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<thead class="center">'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<tr class="head"><th colspan="9">'.$title.'</th></tr>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<tr class="head width5">'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_ID.'</td>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_NAME.'</td>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_TYPE.'</td>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_VALUE.'</th>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_ATTRIBUTE.'</th>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_NULL.'</th>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_DEFAULT.'</th>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_KEY.'</th>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'._AM_TDMCREATE_FIELD_PARAMETERS.'</th>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('</tr></thead>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<tbody>'));

        return $form;
    }

    /**
     * @public function getFormNew
     *
     * @param null $fieldMid
     * @param null $fieldTid
     * @param null $fieldNumb
     * @param null $fieldName
     * @param bool $action
     * @return mixed
     */
    public function getFormNew($fieldMid = null, $fieldTid = null, $fieldNumb = null, $fieldName = null, $action = false)
    {
        $helper = Tdmcreate\Helper::getInstance();
        // Header function class
        $fieldsForm = self::getInstance();
        $form = $fieldsForm->getHeaderForm($action);
        // Get handler tables
        $tableObj = $helper->getHandler('Tables'); // Changed by goffy
        $tableAutoincrement = $tableObj->get($fieldTid)->getVar('table_autoincrement'); // Added by goffy
        // Loop for fields number
        $class = 'even';
        for ($i = 1; $i <= $fieldNumb; ++$i) {
            $class = ('even' === $class) ? 'odd' : 'even';
            // Replaced creation of new line by new function - goffy
            $this->getFormNewLine($form, $class, $i, $fieldMid, $fieldTid, $fieldName, $tableAutoincrement);
        }

        // Footer form
        return $fieldsForm->getFooterForm($form);
    }

    /**
     * @private function getFormNewLine
     *
     * @param $form
     * @param $class
     * @param $i
     * @param $fieldMid
     * @param $fieldTid
     * @param $fName
     * @param $tableAutoincrement
     */
    private function getFormNewLine($form, $class, $i, $fieldMid, $fieldTid, $fName, $tableAutoincrement)
    {
        $helper = Tdmcreate\Helper::getInstance();
        $form->addElement(new \XoopsFormHidden('field_id['.$i.']', 0));
        $form->addElement(new \XoopsFormHidden('field_mid', $fieldMid));
        $form->addElement(new \XoopsFormHidden('field_tid', $fieldTid));

        $form->addElement(new Tdmcreate\Html\FormLabel('<tr class="'.$class.'">'));
        // Index ID
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$i.'</td>'));
        // Field Name
        $thisFieldName = (!empty($fName) ? ((1 == $i) ? $fName.'_id' : $fName.'_') : '');
        $fieldName = new \XoopsFormText(_AM_TDMCREATE_FIELD_NAME, 'field_name['.$i.']', 15, 255, $thisFieldName);
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldName->render().'</td>'));
        // Field Type
        $value = (1 == $i) && (1 == $tableAutoincrement) ? '2' : '';
        $fieldTypeSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_TYPE, 'field_type['.$i.']', $value);
        $fieldTypeSelect->addOptionArray($helper->getHandler('Fieldtype')->getList());
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldTypeSelect->render().'</td>'));
        // Field Value
        $value = (1 == $i) && (1 == $tableAutoincrement) ? '8' : '';
        $fieldValue = new \XoopsFormText(_AM_TDMCREATE_FIELD_VALUE, 'field_value['.$i.']', 10, 200, $value);
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldValue->render().'</td>'));
        // Field Attributes
        $value = (1 == $i) && (1 == $tableAutoincrement) ? '3' : '';
        $fieldAttributesSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_TYPE, 'field_attribute['.$i.']', $value);
        $fieldAttributesSelect->addOptionArray($helper->getHandler('Fieldattributes')->getList());
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldAttributesSelect->render().'</td>'));
        // Field Null
        $value = (1 == $i) && (1 == $tableAutoincrement) ? '2' : '2';
        $fieldNullSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_NULL, 'field_null['.$i.']', $value);
        $fieldNullSelect->addOptionArray($helper->getHandler('Fieldnull')->getList());
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldNullSelect->render().'</td>'));
        // Field Default
        $fieldDefault = new \XoopsFormText(_AM_TDMCREATE_FIELD_DEFAULT, 'field_default['.$i.']', 15, 25);
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldDefault->render().'</td>'));
        // Field Key
        $value = (1 == $i) && (1 == $tableAutoincrement) ? '2' : '';
        $fieldKeySelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_KEY, 'field_key['.$i.']', $value);
        $fieldKeySelect->addOptionArray($helper->getHandler('Fieldkey')->getList());
        $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldKeySelect->render().'</td>'));
        // Field Void
        if ((1 == $i) && (1 == $tableAutoincrement)) {
            $form->addElement(new Tdmcreate\Html\FormLabel('<td>&nbsp;</td></tr>'));
        } else {
            // Box header row
            $parametersTray = new \XoopsFormElementTray('', '<br>');
            // Field Elements
            $crElement = new \CriteriaCompo();
            $crElement->add(new \Criteria('fieldelement_tid', 0));
            $crTable = new \CriteriaCompo();
            $crTable->add(new \Criteria('fieldelement_mid', $fieldMid));
            $fieldElementsSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_ELEMENT_NAME, 'field_element['.$i.']');
            $fieldElementsSelect->addOptionArray($helper->getHandler('Fieldelements')->getList($crElement));
            $fieldElementsSelect->addOptionArray($helper->getHandler('Fieldelements')->getList($crTable));
            unset($crElement, $crTable);
            $parametersTray->addElement($fieldElementsSelect);

            $field_parent = 0;
            $checkFieldParent = new \XoopsFormCheckBox(' ', 'field_parent['.$i.']', $field_parent);
            $checkFieldParent->addOption(1, _AM_TDMCREATE_FIELD_PARENT);
            $parametersTray->addElement($checkFieldParent);

            $field_admin = 0;
            $checkFieldAdmin = new \XoopsFormCheckBox(' ', 'field_admin['.$i.']', $field_admin);
            $checkFieldAdmin->addOption(1, _AM_TDMCREATE_FIELD_ADMIN);
            $parametersTray->addElement($checkFieldAdmin);

            $field_inlist = 0;
            $checkFieldInList = new \XoopsFormCheckBox(' ', 'field_inlist['.$i.']', $field_inlist);
            $checkFieldInList->addOption(1, _AM_TDMCREATE_FIELD_INLIST);
            $parametersTray->addElement($checkFieldInList);

            $field_inform = 0;
            $checkFieldInForm = new \XoopsFormCheckBox(' ', 'field_inform['.$i.']', $field_inform);
            $checkFieldInForm->addOption(1, _AM_TDMCREATE_FIELD_INFORM);
            $parametersTray->addElement($checkFieldInForm);

            $field_user = 0;
            $checkFieldUser = new \XoopsFormCheckBox(' ', 'field_user['.$i.']', $field_user);
            $checkFieldUser->addOption(1, _AM_TDMCREATE_FIELD_USER);
            $parametersTray->addElement($checkFieldUser);

            $field_thead = 0;
            $checkFieldThead = new \XoopsFormCheckBox(' ', 'field_thead['.$i.']', $field_thead);
            $checkFieldThead->addOption(1, _AM_TDMCREATE_FIELD_THEAD);
            $parametersTray->addElement($checkFieldThead);

            $field_tbody = 0;
            $checkFieldTbody = new \XoopsFormCheckBox(' ', 'field_tbody['.$i.']', $field_tbody);
            $checkFieldTbody->addOption(1, _AM_TDMCREATE_FIELD_TBODY);
            $parametersTray->addElement($checkFieldTbody);

            $field_tfoot = 0;
            $checkFieldTfoot = new \XoopsFormCheckBox(' ', 'field_tfoot['.$i.']', $field_tfoot);
            $checkFieldTfoot->addOption(1, _AM_TDMCREATE_FIELD_TFOOT);
            $parametersTray->addElement($checkFieldTfoot);

            $field_block = 0;
            $checkFieldBlock = new \XoopsFormCheckBox('', 'field_block['.$i.']', $field_block);
            $checkFieldBlock->addOption(1, _AM_TDMCREATE_FIELD_BLOCK);
            $parametersTray->addElement($checkFieldBlock);

            $field_search = 0;
            $check_field_search = new \XoopsFormCheckBox(' ', 'field_search['.$i.']', $field_search);
            $check_field_search->addOption(1, _AM_TDMCREATE_FIELD_SEARCH);
            $parametersTray->addElement($check_field_search);

            $field_required = 0;
            $checkFieldRequired = new \XoopsFormCheckBox(' ', 'field_required['.$i.']', $field_required);
            $checkFieldRequired->addOption(1, _AM_TDMCREATE_FIELD_REQUIRED);
            $parametersTray->addElement($checkFieldRequired);

            $fieldMain = (1 == $tableAutoincrement) ? 2 : 1;
            $checkFieldMain = new Tdmcreate\Form\FormRadio('', 'field_main', $fieldMain);
            $checkFieldMain->addOption($i, _AM_TDMCREATE_FIELD_MAIN);
            $parametersTray->addElement($checkFieldMain);

            $form->addElement(new Tdmcreate\Html\FormLabel('<td><div class="portlet"><div class="portlet-header">'._AM_TDMCREATE_FIELD_PARAMETERS_LIST.'</div><div class="portlet-content">'.$parametersTray->render().'</div></div></td></tr>'));
        }
    }

    /**
     * @public function getFormEdit
     *
     * @param null $fieldMid
     * @param null $fieldTid
     * @param bool $action
     * @return mixed
     */
    public function getFormEdit($fieldMid = null, $fieldTid = null, $action = false)
    {
        $helper = Tdmcreate\Helper::getInstance();
        // Header function class
        $fieldsForm = self::getInstance();
        $form = $fieldsForm->getHeaderForm($action);

        $class = 'even';
        // Get the number of fields - goffy
        $tablesHandler = $helper->getHandler('Tables');
        $tables = $tablesHandler->get($fieldTid);
        $tableAutoincrement = $tables->getVar('table_autoincrement');
        $fieldNumb = $tables->getVar('table_nbfields');
        $fName = $tables->getVar('table_fieldname');

        // Get the list of fields
        $cr = new \CriteriaCompo();
        $cr->add(new \Criteria('field_mid', $fieldMid));
        $cr->add(new \Criteria('field_tid', $fieldTid));
        $cr->setSort('field_order'); //added by goffy
        $fields = $helper->getHandler('Fields')->getObjects($cr);
        unset($cr);
        $id = 1;
        foreach ($fields as $field) {
            $class = ('even' === $class) ? 'odd' : 'even';
            $fieldId = (int)$field->getVar('field_id');
            if ($id > $fieldNumb) {   // delete additional fields, if number of fields is reduced - goffy
                $fieldsObj = $helper->getHandler('Fields')->get($fieldId);
                $helper->getHandler('Fields')->delete($fieldsObj, true);
            } else {
                // show field with settings
                $form->addElement(new \XoopsFormHidden('field_id['.$id.']', $fieldId));

                $form->addElement(new Tdmcreate\Html\FormLabel('<tr class="'.$class.'">'));
                // Index ID
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$id.'</td>'));
                // Field Name
                $fieldName = new \XoopsFormText(_AM_TDMCREATE_FIELD_NAME, 'field_name['.$id.']', 15, 255, $field->getVar('field_name'));
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldName->render().'</td>'));
                // Field Type
                $fieldTypeSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_TYPE, 'field_type['.$id.']', $field->getVar('field_type'));
                $fieldTypeSelect->addOptionArray($helper->getHandler('Fieldtype')->getList());
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldTypeSelect->render().'</td>'));
                // Field Value
                $fieldValue = new \XoopsFormText(_AM_TDMCREATE_FIELD_VALUE, 'field_value['.$id.']', 10, 200, $field->getVar('field_value'));
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldValue->render().'</td>'));
                // Field Attributes
                $fieldAttributesSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_TYPE, 'field_attribute['.$id.']', $field->getVar('field_attribute'));
                $fieldAttributesSelect->addOptionArray($helper->getHandler('Fieldattributes')->getList());
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldAttributesSelect->render().'</td>'));
                // Field Null
                $fieldNullSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_NULL, 'field_null['.$id.']', $field->getVar('field_null'));
                $fieldNullSelect->addOptionArray($helper->getHandler('Fieldnull')->getList());
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldNullSelect->render().'</td>'));
                // Field Default
                $fieldDefault = new \XoopsFormText(_AM_TDMCREATE_FIELD_DEFAULT, 'field_default['.$id.']', 15, 25, $field->getVar('field_default'));
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldDefault->render().'</td>'));
                // Field Key
                $fieldKeySelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_KEY, 'field_key['.$id.']', $field->getVar('field_key'));
                $fieldKeySelect->addOptionArray($helper->getHandler('Fieldkey')->getList());
                $form->addElement(new Tdmcreate\Html\FormLabel('<td class="center">'.$fieldKeySelect->render().'</td>'));
                // Field Void
                if ((1 == $id) && (1 == $tableAutoincrement)) {
                    $form->addElement(new Tdmcreate\Html\FormLabel('<td>&nbsp;</td></tr>'));
                } else {
                    // Box header row
                    $parametersTray = new \XoopsFormElementTray('', '<br>');
                    // Field Elements
                    $crElement = new \CriteriaCompo();
                    $crElement->add(new \Criteria('fieldelement_tid', 0));
                    $crTable = new \CriteriaCompo();
                    $crTable->add(new \Criteria('fieldelement_mid', $fieldMid));
                    $fieldElementsSelect = new \XoopsFormSelect(_AM_TDMCREATE_FIELD_ELEMENT_NAME, 'field_element['.$id.']', $field->getVar('field_element'));
                    $fieldElementsSelect->addOptionArray($helper->getHandler('Fieldelements')->getList($crElement));
                    $fieldElementsSelect->addOptionArray($helper->getHandler('Fieldelements')->getList($crTable));
                    unset($crElement, $crTable);
                    $parametersTray->addElement($fieldElementsSelect);

                    $checkFieldParent = new \XoopsFormCheckBox(' ', 'field_parent['.$id.']', $field->getVar('field_parent'));
                    $checkFieldParent->addOption(1, _AM_TDMCREATE_FIELD_PARENT);
                    $parametersTray->addElement($checkFieldParent);

                    $checkFieldAdmin = new \XoopsFormCheckBox(' ', 'field_admin['.$id.']', $field->getVar('field_admin'));
                    $checkFieldAdmin->addOption(1, _AM_TDMCREATE_FIELD_ADMIN);
                    $parametersTray->addElement($checkFieldAdmin);

                    $checkFieldInList = new \XoopsFormCheckBox(' ', 'field_inlist['.$id.']', $field->getVar('field_inlist'));
                    $checkFieldInList->addOption(1, _AM_TDMCREATE_FIELD_INLIST);
                    $parametersTray->addElement($checkFieldInList);

                    $checkFieldInForm = new \XoopsFormCheckBox(' ', 'field_inform['.$id.']', $field->getVar('field_inform'));
                    $checkFieldInForm->addOption(1, _AM_TDMCREATE_FIELD_INFORM);
                    $parametersTray->addElement($checkFieldInForm);

                    $checkFieldUser = new \XoopsFormCheckBox(' ', 'field_user['.$id.']', $field->getVar('field_user'));
                    $checkFieldUser->addOption(1, _AM_TDMCREATE_FIELD_USER);
                    $parametersTray->addElement($checkFieldUser);

                    $checkFieldThead = new \XoopsFormCheckBox(' ', 'field_thead['.$id.']', $field->getVar('field_thead'));
                    $checkFieldThead->addOption(1, _AM_TDMCREATE_FIELD_THEAD);
                    $parametersTray->addElement($checkFieldThead);

                    $checkFieldTbody = new \XoopsFormCheckBox(' ', 'field_tbody['.$id.']', $field->getVar('field_tbody'));
                    $checkFieldTbody->addOption(1, _AM_TDMCREATE_FIELD_TBODY);
                    $parametersTray->addElement($checkFieldTbody);

                    $checkFieldTfoot = new \XoopsFormCheckBox(' ', 'field_tfoot['.$id.']', $field->getVar('field_tfoot'));
                    $checkFieldTfoot->addOption(1, _AM_TDMCREATE_FIELD_TFOOT);
                    $parametersTray->addElement($checkFieldTfoot);

                    $checkFieldBlock = new \XoopsFormCheckBox('', 'field_block['.$id.']', $field->getVar('field_block'));
                    $checkFieldBlock->addOption(1, _AM_TDMCREATE_FIELD_BLOCK);
                    $parametersTray->addElement($checkFieldBlock);

                    $check_field_search = new \XoopsFormCheckBox(' ', 'field_search['.$id.']', $field->getVar('field_search'));
                    $check_field_search->addOption(1, _AM_TDMCREATE_FIELD_SEARCH);
                    $parametersTray->addElement($check_field_search);

                    $checkFieldRequired = new \XoopsFormCheckBox(' ', 'field_required['.$id.']', $field->getVar('field_required'));
                    $checkFieldRequired->addOption(1, _AM_TDMCREATE_FIELD_REQUIRED);
                    $parametersTray->addElement($checkFieldRequired);

                    $fieldMain = (1 == $field->getVar('field_main')) ? $id : 1;
                    $checkFieldMain = new Tdmcreate\Form\FormRadio('', 'field_main', $fieldMain);
                    $checkFieldMain->addOption($id, _AM_TDMCREATE_FIELD_MAIN);
                    $parametersTray->addElement($checkFieldMain);

                    $form->addElement(new Tdmcreate\Html\FormLabel('<td><div class="portlet"><div class="portlet-header">'._AM_TDMCREATE_FIELD_PARAMETERS_LIST.'</div><div class="portlet-content">'.$parametersTray->render().'</div></div></td></tr>'));
                }
            }
            ++$id;
        }
        // If you change number fields in tables,
        // adding missing fields or delete unnecessary fields
        // By goffy
        for ($i = $id; $i <= $fieldNumb; ++$i) {
            $class = ('even' === $class) ? 'odd' : 'even';
            $this->getFormNewLine($form, $class, $i, $fieldMid, $fieldTid, $fName, $tableAutoincrement);
        }
        unset($id);

        // Footer form
        return $fieldsForm->getFooterForm($form);
    }

    /**
     * @private function getFooterForm
     *
     * @param $form
     *
     * @return mixed
     */
    private function getFooterForm($form)
    {
        // Send Form Data
        $form->addElement(new Tdmcreate\Html\FormLabel('</tbody>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<tfoot><tr>'));
        $formHidden = new \XoopsFormHidden('op', 'save');
        $formButton = new \XoopsFormButton('', 'submit', _SUBMIT, 'submit');
        $form->addElement(new Tdmcreate\Html\FormLabel('<td colspan="8">'.$formHidden->render().'</td>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('<td>'.$formButton->render().'</td>'));
        $form->addElement(new Tdmcreate\Html\FormLabel('</tr></tfoot></table>'));

        return $form;
    }

    /**
     * Get Values.
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesFields($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id'] = $this->getVar('field_id');
        $ret['mid'] = $this->getVar('field_mid');
        $ret['tid'] = $this->getVar('field_tid');
        $ret['order'] = $this->getVar('field_order');
        $ret['name'] = str_replace('_', ' ', ucfirst($this->getVar('field_name')));
        $ret['parent'] = $this->getVar('field_parent');
        $ret['inlist'] = $this->getVar('field_inlist');
        $ret['inform'] = $this->getVar('field_inform');
        $ret['admin'] = $this->getVar('field_admin');
        $ret['user'] = $this->getVar('field_user');
        $ret['block'] = $this->getVar('field_block');
        $ret['main'] = $this->getVar('field_main');
        $ret['search'] = $this->getVar('field_search');
        $ret['required'] = $this->getVar('field_required');

        return $ret;
    }
}

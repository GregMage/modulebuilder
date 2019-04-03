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
 * tdmcreate module.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 *
 * @since           2.5.0
 *
 * @author          Txmod Xoops http://www.txmodxoops.org
 *
 * @version         $Id: TemplatesUserRate.php 12258 2014-01-02 09:33:29Z timgno $
 */

/**
 * Class TemplatesUserRate.
 */
class TemplatesUserRate extends TDMCreateFile
{
    /**
     *  @public function constructor
     *  @param null
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  @static function getInstance
     *  @param null
     * @return TemplatesUserRate
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
     *  @public function write
     *  @param string $module
     *  @param string $table
     *  @param string $filename
     */
    public function write($module, $table, $filename)
    {
        $this->setModule($module);
        $this->setTable($table);
        $this->setFileName($filename);
    }

    /**
     *  @private function getTemplatesUserRateHeader
     *  @param string $moduleDirname
     *  @param string $table
     *  @param string $language
     *
     * @return string
     */
    private function getTemplatesUserRateHeader($moduleDirname, $table, $language)
    {
        $ret = <<<EOT
<{include file="db:{$moduleDirname}_header.tpl"}>
<table class="{$moduleDirname}">
    <thead class="outer">
        <tr class="head">\n
EOT;
        $fields = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));
        foreach (array_keys($fields) as $f) {
            $fieldName = $fields[$f]->getVar('field_name');
            $langStuFieldName = $language . mb_strtoupper($fieldName);
            if ((1 == $table->getVar('table_autoincrement')) || (1 == $fields[$f]->getVar('field_user'))) {
                $ret .= <<<EOT
            <th class="center"><{\$smarty.const.{$langStuFieldName}}></th>\n
EOT;
            }
        }
        $ret .= <<<EOT
        </tr>
    </thead>\n
EOT;

        return $ret;
    }

    /**
     *  @private function getTemplatesUserRateBody
     *  @param string $moduleDirname
     *  @param string $table
     *  @param string $language
     *
     * @return string
     */
    private function getTemplatesUserRateBody($moduleDirname, $table, $language)
    {
        $tableName = $table->getVar('table_name');
        $ret = <<<EOT
    <tbody>
        <{foreach item=list from=\${$tableName}}>
            <tr class="<{cycle values='odd, even'}>">\n
EOT;
        $fields = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));
        foreach (array_keys($fields) as $f) {
            $fieldName = $fields[$f]->getVar('field_name');
            $fieldElement = $fields[$f]->getVar('field_element');
            $rpFieldName = $this->getRightString($fieldName);
            if ((1 == $table->getVar('table_autoincrement')) || (1 == $fields[$f]->getVar('field_user'))) {
                switch ($fieldElement) {
                    case 9:
                        $ret .= <<<EOT
                <td class="center"><span style="background-color: #<{\$list.{$rpFieldName}}>;">\t\t</span></td>\n
EOT;
                        break;
                    case 10:
                        $ret .= <<<EOT
                <td class="center"><img src="<{xoModuleIcons32}><{\$list.{$rpFieldName}}>" alt="{$tableName}"></td>\n
EOT;
                        break;
                    case 13:
                        $ret .= <<<EOT
                <td class="center"><img src="<{\${$moduleDirname}_upload_url}>/images/{$tableName}/<{\$list.{$rpFieldName}}>" alt="{$tableName}"></td>\n
EOT;
                        break;
                    default:
                        $ret .= <<<EOT
                <td class="center"><{\$list.{$rpFieldName}}></td>\n
EOT;
                        break;
                }
            }
        }
        $ret .= <<<EOT
            </tr>
        <{/foreach}>
    </tbody>
</table>\n
EOT;

        return $ret;
    }

    /**
     *  @private function getTemplatesUserRateBodyFieldnameEmpty
     *  @param string $moduleDirname
     *  @param string $table
     *  @param string $language
     *
     * @return string
     */
    private function getTemplatesUserRateBodyFieldnameEmpty($moduleDirname, $table, $language)
    {
        $tableName = $table->getVar('table_name');
        $ret = <<<EOT
    <tbody>
        <{foreach item=list from=\${$tableName}}>
            <tr class="<{cycle values='odd, even'}>">\n
EOT;
        $fields = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));
        foreach (array_keys($fields) as $f) {
            $fieldName = $fields[$f]->getVar('field_name');
            $fieldElement = $fields[$f]->getVar('field_element');
            if ((1 == $table->getVar('table_autoincrement')) || (1 == $fields[$f]->getVar('field_user'))) {
                switch ($fieldElement) {
                    case 9:
                        $ret .= <<<EOT
            <td class="center"><span style="background-color: #<{\$list.{$fieldName}}>;"></span></td>\n
EOT;
                        break;
                    case 13:
                        $ret .= <<<EOT
            <td class="center"><img src="<{\${$moduleDirname}_upload_url}>/images/{$tableName}/<{\$list.{$fieldName}}>" alt="{$tableName}"></td>\n
EOT;
                        break;
                    default:
                        $ret .= <<<EOT
            <td class="center"><{\$list.{$fieldName}}></td>\n
EOT;
                        break;
                }
            }
        }
        $ret .= <<<EOT
            </tr>
        <{/foreach}>
    </tbody>
</table>\n
EOT;

        return $ret;
    }

    /**
     *  @private function getTemplatesUserRateFooter
     *  @param string $moduleDirname
     *
     * @return string
     */
    private function getTemplatesUserRateFooter($moduleDirname)
    {
        $ret = <<<EOT
<{include file="db:{$moduleDirname}_footer.tpl"}>
EOT;

        return $ret;
    }

    /**
     *  @public function render
     *  @param null
     * @return bool|string
     */
    public function render()
    {
        $module = $this->getModule();
        $table = $this->getTable();
        $filename = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');
        $tableFieldname = $table->getVar('table_fieldname');
        $language = $this->getLanguage($moduleDirname, 'MA');
        $content = $this->getTemplatesUserRateHeader($moduleDirname, $table, $language);
        // Verify if table_fieldname is not empty
        if (!empty($tableFieldname)) {
            $content .= $this->getTemplatesUserRateBody($moduleDirname, $table, $language);
        } else {
            $content .= $this->getTemplatesUserRateBodyFieldnameEmpty($moduleDirname, $table, $language);
        }
        $content .= $this->getTemplatesUserRateFooter($moduleDirname);

        $this->create($moduleDirname, 'templates', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}

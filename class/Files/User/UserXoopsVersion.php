<?php

namespace XoopsModules\Tdmcreate\Files\User;

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
 * Class UserXoopsVersion.
 */
class UserXoopsVersion extends Files\CreateFile
{
    /**
     * @var array
     */
    private $kw = [];

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
     * @return UserXoopsVersion
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
     * @param       $module
     * @param mixed $table
     * @param mixed $tables
     * @param       $filename
     */
    public function write($module, $table, $tables, $filename)
    {
        $this->setModule($module);
        $this->setTable($table);
        $this->setTables($tables);
        $this->setFileName($filename);
        foreach (array_keys($tables) as $t) {
            $tableName = $tables[$t]->getVar('table_name');
            $this->setKeywords($tableName);
        }
    }

    /**
     * @public function setKeywords
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        if (is_array($keywords)) {
            $this->kw = $keywords;
        } else {
            $this->kw[] = $keywords;
        }
    }

    /**
     * @public function getKeywords
     * @param null
     * @return array
     */
    public function getKeywords()
    {
        return $this->kw;
    }

    /**
     * @private function getXoopsVersionHeader
     * @param $module
     * @param $language
     *
     * @return string
     */
    private function getXoopsVersionHeader($module, $language)
    {
        $xCodeVHeader = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $uCodeVHeader = UserXoopsCode::getInstance();
        $date         = date('Y/m/d');
        $ret          = $this->getSimpleString('');
        $ret          .= Tdmcreate\Files\CreatePhpCode::getInstance()->getPhpCodeCommentLine();
        $ret          .= $xCodeVHeader->getXcEqualsOperator('$moduleDirName     ', 'basename(__DIR__)');
        $ret          .= $xCodeVHeader->getXcEqualsOperator('$moduleDirNameUpper', 'mb_strtoupper($moduleDirName)');
        $ret          .= $this->getDashComment('Informations');
        $ha           = (1 == $module->getVar('mod_admin')) ? 1 : 0;
        $hm           = (1 == $module->getVar('mod_user')) ? 1 : 0;

        $descriptions = [
            'name'                => "{$language}NAME",
            'version'             => (string)$module->getVar('mod_version'),
            'description'         => "{$language}DESC",
            'author'              => "'{$module->getVar('mod_author')}'",
            'author_mail'         => "'{$module->getVar('mod_author_mail')}'",
            'author_website_url'  => "'{$module->getVar('mod_author_website_url')}'",
            'author_website_name' => "'{$module->getVar('mod_author_website_name')}'",
            'credits'             => "'{$module->getVar('mod_credits')}'",
            'license'             => "'{$module->getVar('mod_license')}'",
            'license_url'         => "'http://www.gnu.org/licenses/gpl-3.0.en.html'",
            'help'                => "'page=help'",
            'release_info'        => "'{$module->getVar('mod_release_info')}'",
            'release_file'        => "XOOPS_URL . '/modules/{$module->getVar('mod_dirname')}/docs/{$module->getVar('mod_release_file')}'",
            'release_date'        => "'{$date}'",
            'manual'              => "'{$module->getVar('mod_manual')}'",
            'manual_file'         => "XOOPS_URL . '/modules/{$module->getVar('mod_dirname')}/docs/{$module->getVar('mod_manual_file')}'",
            'min_php'             => "'{$module->getVar('mod_min_php')}'",
            'min_xoops'           => "'{$module->getVar('mod_min_xoops')}'",
            'min_admin'           => "'{$module->getVar('mod_min_admin')}'",
            'min_db'              => "array('mysql' => '{$module->getVar('mod_min_mysql')}', 'mysqli' => '{$module->getVar('mod_min_mysql')}')",
            'image'               => "'assets/images/logoModule.png'",
            'dirname'             => 'basename(__DIR__)',
            'dirmoduleadmin'      => "'Frameworks/moduleclasses/moduleadmin'",
            'sysicons16'          => "'../../Frameworks/moduleclasses/icons/16'",
            'sysicons32'          => "'../../Frameworks/moduleclasses/icons/32'",
            'modicons16'          => "'assets/icons/16'",
            'modicons32'          => "'assets/icons/32'",
            'demo_site_url'       => "'{$module->getVar('mod_demo_site_url')}'",
            'demo_site_name'      => "'{$module->getVar('mod_demo_site_name')}'",
            'support_url'         => "'{$module->getVar('mod_support_url')}'",
            'support_name'        => "'{$module->getVar('mod_support_name')}'",
            'module_website_url'  => "'{$module->getVar('mod_website_url')}'",
            'module_website_name' => "'{$module->getVar('mod_website_name')}'",
            'release'             => "'{$module->getVar('mod_release')}'",
            'module_status'       => "'{$module->getVar('mod_status')}'",
            'system_menu'         => '1',
            'hasAdmin'            => $ha,
            'hasMain'             => $hm,
            'adminindex'          => "'admin/index.php'",
            'adminmenu'           => "'admin/menu.php'",
            'onInstall'           => "'include/install.php'",
            'onUninstall'         => "'include/uninstall.php'",
            'onUpdate'            => "'include/update.php'",
        ];

        $ret .= $uCodeVHeader->getUserModVersionArray(0, $descriptions);

        return $ret;
    }

    /**
     * @private function getXoopsVersionMySQL
     * @param $moduleDirname
     * @param $table
     * @param $tables
     * @return string
     */
    private function getXoopsVersionMySQL($moduleDirname, $table, $tables)
    {
        $uCodeVMySQL = UserXoopsCode::getInstance();
        $tableName   = $table->getVar('table_name');
        $n           = 1;
        $ret         = '';
        if (!empty($tableName)) {
            $ret .= $this->getDashComment('Mysql');
            $description = "'sql/mysql.sql'";
            $ret .= $uCodeVMySQL->getUserModVersionText(2, $description, 'sqlfile', "'mysql'");
            $ret .= Tdmcreate\Files\CreatePhpCode::getInstance()->getPhpCodeCommentLine('Tables');

            foreach (array_keys($tables) as $t) {
                $items[] = "'{$moduleDirname}_{$tables[$t]->getVar('table_name')}'";
                ++$n;
            }
            $ret .= $uCodeVMySQL->getUserModVersionArray(11, $items, 'tables', $n);
            unset($n);
        }

        return $ret;
    }

    /**
     * @private function getXoopsVersionSearch
     * @param $moduleDirname
     *
     * @return string
     */
    private function getXoopsVersionSearch($moduleDirname)
    {
        $uCodeVSearch = UserXoopsCode::getInstance();
        $ret          = $this->getDashComment('Search');
        $ret          .= $uCodeVSearch->getUserModVersionText(1, 1, 'hasSearch');
        $items        = ['file' => "'include/search.inc.php'", 'func' => "'{$moduleDirname}_search'"];
        $ret          .= $uCodeVSearch->getUserModVersionArray(1, $items, 'search');

        return $ret;
    }

    /**
     * @private function getXoopsVersionComments
     * @param $moduleDirname
     *
     * @return string
     */
    private function getXoopsVersionComments($moduleDirname)
    {
        $uCodeVComments = UserXoopsCode::getInstance();
        $ret            = $this->getDashComment('Comments');
        $ret            .= $uCodeVComments->getUserModVersionText(2, "'comments.php'", 'comments', "'pageName'");
        $ret            .= $uCodeVComments->getUserModVersionText(2, "'com_id'", 'comments', "'itemName'");
        $ret            .= Tdmcreate\Files\CreatePhpCode::getInstance()->getPhpCodeCommentLine('Comment callback functions');
        $ret            .= $uCodeVComments->getUserModVersionText(2, "'include/comment_functions.php'", 'comments', "'callbackFile'");
        $descriptions   = ['approve' => "'{$moduleDirname}CommentsApprove'", 'update' => "'{$moduleDirname}CommentsUpdate'"];
        $ret            .= $uCodeVComments->getUserModVersionArray(2, $descriptions, 'comments', "'callback'");

        return $ret;
    }

    /**
     * @private function getXoopsVersionTemplatesAdminUser
     * @param $moduleDirname
     * @param $tables
     *
     * @return string
     */
    private function getXoopsVersionTemplatesAdminUser($moduleDirname, $tables, $admin, $user)
    {
        $uCodeTemplate = UserXoopsCode::getInstance();
        $ret = $this->getDashComment('Templates');

        if ($admin) {
            $item[] = Tdmcreate\Files\CreatePhpCode::getInstance()->getPhpCodeCommentLine('Admin templates');
            $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'about', '', true);
            $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'header', '', true);
            $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'index', '', true);
            $tablePermissions = [];
            foreach (array_keys($tables) as $t) {
                $tableName          = $tables[$t]->getVar('table_name');
                $tablePermissions[] = $tables[$t]->getVar('table_permissions');
                $item[]             .= $this->getXoopsVersionTemplatesLine($moduleDirname, $tableName, '', true);
            }
            if (in_array(1, $tablePermissions)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'permissions', '', true);
            }
            $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'footer', '', true);
        }

        if ($user) {
            $item[]      = Tdmcreate\Files\CreatePhpCode::getInstance()->getPhpCodeCommentLine('User templates');
            $item[]      = $this->getXoopsVersionTemplatesLine($moduleDirname, 'header', '');
            $item[]      = $this->getXoopsVersionTemplatesLine($moduleDirname, 'index', '');
            $tableBroken = [];
            $tablePdf    = [];
            $tablePrint  = [];
            $tableRate   = [];
            $tableRss    = [];
            $tableSearch = [];
            $tableSingle = [];
            $tableSubmit = [];
            foreach (array_keys($tables) as $t) {
                $tableName     = $tables[$t]->getVar('table_name');
                $tableBroken[] = $tables[$t]->getVar('table_broken');
                $tablePdf[]    = $tables[$t]->getVar('table_pdf');
                $tablePrint[]  = $tables[$t]->getVar('table_print');
                $tableRate[]   = $tables[$t]->getVar('table_rate');
                $tableRss[]    = $tables[$t]->getVar('table_rss');
                $tableSearch[] = $tables[$t]->getVar('table_search');
                $tableSingle[] = $tables[$t]->getVar('table_single');
                $tableSubmit[] = $tables[$t]->getVar('table_submit');
                $item[]        = $this->getXoopsVersionTemplatesLine($moduleDirname, $tableName, '');
                $item[]        = $this->getXoopsVersionTemplatesLine($moduleDirname, $tableName, 'list');
            }
            $item[]  = $this->getXoopsVersionTemplatesLine($moduleDirname, 'breadcrumbs', '');
            if (in_array(1, $tableBroken)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'broken', '');
            }
            if (in_array(1, $tablePdf)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'pdf', '');
            }
            if (in_array(1, $tablePrint)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'print', '');
            }
            if (in_array(1, $tableRate)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'rate', '');
            }
            if (in_array(1, $tableRss)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'rss', '');
            }
            if (in_array(1, $tableSearch)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'search', '');
            }
            if (in_array(1, $tableSingle)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'single', '');
            }
            if (in_array(1, $tableSubmit)) {
                $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'submit', '');
            }
            $item[] = $this->getXoopsVersionTemplatesLine($moduleDirname, 'footer', '');
        }

        $ret .= $uCodeTemplate->getUserModVersionArray(11, $item, "templates");

        return $ret;
    }

    /**
     * @private function getXoopsVersionTemplatesLine
     * @param        $moduleDirname
     * @param        $type
     * @param string $extra
     * @param bool   $isAdmin
     * @return string
     */
    private function getXoopsVersionTemplatesLine($moduleDirname, $type, $extra = '', $isAdmin = false)
    {
        $ret         = '';
        $desc        = "'description' => ''";
        $arrayFile   = "['file' =>";
        if ($isAdmin) {
            $ret .= "{$arrayFile} '{$moduleDirname}_admin_{$type}.tpl', {$desc}, 'type' => 'admin']";
        } else {
            if ('' !== $extra) {
                $ret .= "{$arrayFile} '{$moduleDirname}_{$type}_{$extra}.tpl', {$desc}]";
            } else {
                $ret .= "{$arrayFile} '{$moduleDirname}_{$type}.tpl', {$desc}]";
            }
        }

        return $ret;
    }

    /**
     * @private function getXoopsVersionSubmenu
     * @param $language
     * @param $tables
     * @return string
     */
    private function getXoopsVersionSubmenu($language, $tables)
    {
        $cpc = Tdmcreate\Files\CreatePhpCode::getInstance();
        $cxc = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $uxc = UserXoopsCode::getInstance();
        $cf = Tdmcreate\Files\CreateFile::getInstance();

        $ret     = $this->getDashComment('Menu');
        $xModule = $cpc->getPhpCodeGlobals('xoopsModule');
        $cond    = 'isset(' . $xModule . ') && is_object(' . $xModule . ')';
        $one     =  $cpc->getPhpCodeGlobals('xoopsModule') . "->getVar('dirname')";
        $ret     .= $cpc->getPhpCodeTernaryOperator('currdirname ', $cond, $one, "'system'");

        $i          = 1;
        $descriptions = [
            'name' => "{$language}SMNAME{$i}",
            'url'  => "'index.php'",
        ];
        $contentIf  = $uxc->getUserModVersionArray(2, $descriptions, 'sub', '','', "\t");

        $tableSubmit = [];
        $tableSearch = [];
        foreach (array_keys($tables) as $t) {
            $tableName     = $tables[$t]->getVar('table_name');
            $tableSubmit[] = $tables[$t]->getVar('table_submit');
            $tableSearch[] = $tables[$t]->getVar('table_search');
            if (1 == $tables[$t]->getVar('table_submenu')) {
                $contentIf .= $cpc->getPhpCodeCommentLine('Sub', $tableName, "\t");
                $descriptions = [
                    'name' => "{$language}SMNAME{$i}",
                    'url'  => "'{$tableName}.php'",
                ];
                $contentIf  .= $uxc->getUserModVersionArray(2, $descriptions, 'sub', '','', "\t");
                unset($item);
            }
            ++$i;
        }
        if (in_array(1, $tableSubmit)) {
            $contentIf .= $cpc->getPhpCodeCommentLine('Sub', 'Submit', "\t");
            $descriptions = [
                'name' => "{$language}SMNAME{$i}",
                'url'  => "'submit.php'",
            ];
            $contentIf  .= $uxc->getUserModVersionArray(2, $descriptions, 'sub', '','', "\t");
            ++$i;
        }
        if (in_array(1, $tableSearch)) {
            $contentIf .= $cpc->getPhpCodeCommentLine('Sub', 'Search', "\t");
            $descriptions = [
                'name' => "{$language}SMNAME{$i}",
                'url'  => "'search.php'",
            ];
            $contentIf  .= $uxc->getUserModVersionArray(2, $descriptions, 'sub', '','', "\t");
        }

        unset($i);

        $ret .= $cpc->getPhpCodeConditions('$moduleDirName', ' == ', '$currdirname', $contentIf);

        return $ret;
    }

    /**
     * @private function getXoopsVersionBlocks
     * @param $moduleDirname
     * @param $tables
     * @param $language
     * @return string
     */
    private function getXoopsVersionBlocks($moduleDirname, $tables, $language)
    {
        $ret           = $this->getDashComment('Blocks');
        $tableCategory = [];
        foreach (array_keys($tables) as $i) {
            $tableName        = $tables[$i]->getVar('table_name');
            $tableFieldName   = $tables[$i]->getVar('table_fieldname');
            $tableSoleName    = $tables[$i]->getVar('table_solename');
            $stuTableSoleName = mb_strtoupper($tableSoleName);
            $tableCategory[]  = $tables[$i]->getVar('table_category');
            //if (in_array(1, $tableCategory)) {
            //$ret .= $this->getXoopsVersionTypeBlocks($moduleDirname, $tableName, $stuTableSoleName, $language, $tableFieldName);
            //} else {
            if (0 == $tables[$i]->getVar('table_category')) {
                $ret .= $this->getXoopsVersionTypeBlocks($moduleDirname, $tableName, 'LAST', $language, 'last');
                $ret .= $this->getXoopsVersionTypeBlocks($moduleDirname, $tableName, 'NEW', $language, 'new');
                $ret .= $this->getXoopsVersionTypeBlocks($moduleDirname, $tableName, 'HITS', $language, 'hits');
                $ret .= $this->getXoopsVersionTypeBlocks($moduleDirname, $tableName, 'TOP', $language, 'top');
                $ret .= $this->getXoopsVersionTypeBlocks($moduleDirname, $tableName, 'RANDOM', $language, 'random');
            }
        }

        return $ret;
    }

    /**
     * @private function getXoopsVersionTypeBlocks
     * @param $moduleDirname
     * @param $tableName
     * @param $stuTableSoleName
     * @param $language
     * @param $type
     * @return string
     */
    private function getXoopsVersionTypeBlocks($moduleDirname, $tableName, $stuTableSoleName, $language, $type)
    {
        $phpCodeVTBlocks = Tdmcreate\Files\CreatePhpCode::getInstance();
        $uCodeVTBlocks   = UserXoopsCode::getInstance();
        $stuTableName    = mb_strtoupper($tableName);
        $ucfTableName    = ucfirst($tableName);
        $ret             = $phpCodeVTBlocks->getPhpCodeCommentLine($ucfTableName . ' ' . $type);
        $blocks          = [
            'file'        => "'{$tableName}.php'",
            'name'        => "{$language}{$stuTableName}_BLOCK_{$stuTableSoleName}",
            'description' => "{$language}{$stuTableName}_BLOCK_{$stuTableSoleName}_DESC",
            'show_func'   => "'b_{$moduleDirname}_{$tableName}_show'",
            'edit_func'   => "'b_{$moduleDirname}_{$tableName}_edit'",
            'template'    => "'{$moduleDirname}_block_{$tableName}.tpl'",
            'options'     => "'{$type}|5|25|0'",
        ];
        $ret             .= $uCodeVTBlocks->getUserModVersionArray(2, $blocks, 'blocks');

        return $ret;
    }

    /**
     * @private function getXoopsVersionConfig
     * @param $module
     * @param $tables
     * @param $language
     *
     * @return string
     */
    private function getXoopsVersionConfig($module, $tables, $language)
    {
        $phpCodeVConfig = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xCodeVConfig   = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $uCodeVConfig   = UserXoopsCode::getInstance();
        $moduleDirname  = $module->getVar('mod_dirname');
        $ret            = $this->getDashComment('Config');

        $table_permissions = 0;
        $table_admin       = 0;
        $table_user        = 0;
        $table_tag         = 0;
        $field_images      = 0;
        foreach ($tables as $table) {
            $fields = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));
            foreach (array_keys($fields) as $f) {
                $fieldElement = (int)$fields[$f]->getVar('field_element');
                switch ($fieldElement) {
                    case 3:
                    case 4:
                        $fieldName    = $fields[$f]->getVar('field_name');
                        $rpFieldName  = $this->getRightString($fieldName);
                        $ucfFieldName = ucfirst($rpFieldName);
                        $stuFieldName = mb_strtoupper($rpFieldName);
                        $ret          .= $phpCodeVConfig->getPhpCodeCommentLine('Editor', $rpFieldName);
                        $ret          .= $xCodeVConfig->getXcLoad('xoopseditorhandler');
                        $ret          .= $xCodeVConfig->getXcEqualsOperator('$editorHandler' . $ucfFieldName, 'XoopsEditorHandler::getInstance()');
                        $editor       = [
                            'name'        => "'editor_{$rpFieldName}'",
                            'title'       => "'{$language}EDITOR_{$stuFieldName}'",
                            'description' => "'{$language}EDITOR_{$stuFieldName}_DESC'",
                            'formtype'    => "'select'",
                            'valuetype'   => "'text'",
                            'default'     => "'dhtml'",
                            'options'     => 'array_flip($editorHandler' . $ucfFieldName . '->getList())',
                        ];
                        $ret          .= $uCodeVConfig->getUserModVersionArray(2, $editor, 'config');
                        break;
                    case 10:
                    case 11:
                    case 12:
                    case 13:
                        $table_uploadimage = 1;
                    case 14:
                        $table_uploadfile = 1;
                        break;
                    case 'else':
                    default:
                        break;
                }
            }
            if (1 == $table->getVar('table_permissions')) {
                $table_permissions = 1;
            }
            if (1 == $table->getVar('table_admin')) {
                $table_admin = 1;
            }
            if (1 == $table->getVar('table_user')) {
                $table_user = 1;
            }
            if (1 == $table->getVar('table_tag')) {
                $table_tag = 1;
            }
        }

        if (1 === $table_permissions) {
            $ret    .= $phpCodeVConfig->getPhpCodeCommentLine('Get groups');
            $ret    .= $xCodeVConfig->getXcEqualsOperator('$memberHandler ', "xoops_getHandler('member')", '', false);
            $ret    .= $xCodeVConfig->getXcEqualsOperator('$xoopsGroups ', '$memberHandler->getGroupList()');
            $group  = $xCodeVConfig->getXcEqualsOperator('$groups[$group] ', '$key', null, false, "\t");
            $ret    .= $phpCodeVConfig->getPhpCodeForeach('xoopsGroups', false, 'key', 'group', $group);
            $ret    .= $phpCodeVConfig->getPhpCodeCommentLine('General access groups');
            $groups = [
                'name'        => "'groups'",
                'title'       => "'{$language}GROUPS'",
                'description' => "'{$language}GROUPS_DESC'",
                'formtype'    => "'select_multi'",
                'valuetype'   => "'array'",
                'default'     => '$groups',
                'options'     => '$groups',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $groups, 'config');
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Upload groups');
            $uplgroups  = [
                'name'        => "'upload_groups'",
                'title'       => "'{$language}UPLOAD_GROUPS'",
                'description' => "'{$language}UPLOAD_GROUPS_DESC'",
                'formtype'    => "'select_multi'",
                'valuetype'   => "'array'",
                'default'     => '$groups',
                'options'     => '$groups',
            ];
            $ret         .= $uCodeVConfig->getUserModVersionArray(2, $uplgroups, 'config');

            $ret         .= $phpCodeVConfig->getPhpCodeCommentLine('Get Admin groups');
            $ret         .= $xCodeVConfig->getXcEqualsOperator('$criteria ', 'new \CriteriaCompo()');
            $ret         .= $this->getSimpleString("\$criteria->add( new \Criteria( 'group_type', 'Admin' ) );");
            $ret         .= $xCodeVConfig->getXcEqualsOperator('$memberHandler ', "xoops_getHandler('member')", '', false);
            $ret         .= $xCodeVConfig->getXcEqualsOperator('$adminXoopsGroups ', '$memberHandler->getGroupList($criteria)');
            $adminGroup  = $xCodeVConfig->getXcEqualsOperator('$adminGroups[$adminGroup] ', '$key', null, false, "\t");
            $ret         .= $phpCodeVConfig->getPhpCodeForeach('adminXoopsGroups', false, 'key', 'adminGroup', $adminGroup);
            $adminGroups = [
                'name'        => "'admin_groups'",
                'title'       => "'{$language}ADMIN_GROUPS'",
                'description' => "'{$language}ADMIN_GROUPS_DESC'",
                'formtype'    => "'select_multi'",
                'valuetype'   => "'array'",
                'default'     => '$adminGroups',
                'options'     => '$adminGroups',
            ];
            $ret         .= $uCodeVConfig->getUserModVersionArray(2, $adminGroups, 'config');
        }
        $keyword      = implode(', ', $this->getKeywords());
        $ret          .= $phpCodeVConfig->getPhpCodeCommentLine('Keywords');
        $arrayKeyword = [
            'name'        => "'keywords'",
            'title'       => "'{$language}KEYWORDS'",
            'description' => "'{$language}KEYWORDS_DESC'",
            'formtype'    => "'textbox'",
            'valuetype'   => "'text'",
            'default'     => "'{$moduleDirname}, {$keyword}'",
        ];
        $ret .= $uCodeVConfig->getUserModVersionArray(2, $arrayKeyword, 'config');
        unset($this->keywords);

        if (1 === $table_uploadimage || 1 === $table_uploadfile) {
            $ret       .= $this->getXoopsVersionSelectSizeMB($moduleDirname);
        }
        if (1 === $table_uploadimage) {
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Uploads : maxsize of image');
            $maxsize_image    = [
                'name'        => "'maxsize_image'",
                'title'       => "'{$language}MAXSIZE_IMAGE'",
                'description' => "'{$language}MAXSIZE_IMAGE_DESC'",
                'formtype'    => "'select'",
                'valuetype'   => "'int'",
                'default'     => '3145728',
                'options'     => '$optionMaxsize',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $maxsize_image, 'config');
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Uploads : mimetypes of image');
            $mimetypes_image  = [
                'name'        => "'mimetypes_image'",
                'title'       => "'{$language}MIMETYPES_IMAGE'",
                'description' => "'{$language}MIMETYPES_IMAGE_DESC'",
                'formtype'    => "'select_multi'",
                'valuetype'   => "'array'",
                'default'     => "['image/gif', 'image/jpeg', 'image/png']",
                'options'     => "['bmp' => 'image/bmp','gif' => 'image/gif','pjpeg' => 'image/pjpeg', 'jpeg' => 'image/jpeg','jpg' => 'image/jpg','jpe' => 'image/jpe', 'png' => 'image/png']",
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $mimetypes_image, 'config');
            $maxwidth_image   = [
                'name'        => "'maxwidth_image'",
                'title'       => "'{$language}MAXWIDTH_IMAGE'",
                'description' => "'{$language}MAXWIDTH_IMAGE_DESC'",
                'formtype'    => "'textbox'",
                'valuetype'   => "'int'",
                'default'     => '8000',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $maxwidth_image, 'config');
            $maxheight_image   = [
                'name'        => "'maxheight_image'",
                'title'       => "'{$language}MAXHEIGHT_IMAGE'",
                'description' => "'{$language}MAXHEIGHT_IMAGE_DESC'",
                'formtype'    => "'textbox'",
                'valuetype'   => "'int'",
                'default'     => '8000',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $maxheight_image, 'config');
        }
        if (1 === $table_uploadfile) {
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Uploads : maxsize of file');
            $maxsize_file     = [
                'name'        => "'maxsize_file'",
                'title'       => "'{$language}MAXSIZE_FILE'",
                'description' => "'{$language}MAXSIZE_FILE_DESC'",
                'formtype'    => "'select'",
                'valuetype'   => "'int'",
                'default'     => '3145728',
                'options'     => '$optionMaxsize',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $maxsize_file, 'config');
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Uploads : mimetypes of file');
            $mimetypes_file   = [
                'name'        => "'mimetypes_file'",
                'title'       => "'{$language}MIMETYPES_FILE'",
                'description' => "'{$language}MIMETYPES_FILE_DESC'",
                'formtype'    => "'select_multi'",
                'valuetype'   => "'array'",
                'default'     => "['pdf' => 'application/pdf','zip' => 'application/zip','csv' => 'text/comma-separated-values', 'txt' => 'text/plain']",
                'options'     => "[
                                  'pdf' => 'application/pdf','zip' => 'application/zip','csv' => 'text/comma-separated-values', 'txt' => 'text/plain', 'xml' => 'application/xml',
                                  'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                  ]",
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $mimetypes_file, 'config');
        }
        if (1 === $table_admin) {
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Admin pager');
            $adminPager = [
                'name'        => "'adminpager'",
                'title'       => "'{$language}ADMIN_PAGER'",
                'description' => "'{$language}ADMIN_PAGER_DESC'",
                'formtype'    => "'textbox'",
                'valuetype'   => "'int'",
                'default'     => '10',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $adminPager, 'config');
        }
        if (1 === $table_user) {
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('User pager');
            $userPager = [
                'name'        => "'userpager'",
                'title'       => "'{$language}USER_PAGER'",
                'description' => "'{$language}USER_PAGER_DESC'",
                'formtype'    => "'textbox'",
                'valuetype'   => "'int'",
                'default'     => '10',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $userPager, 'config');
        }
        if (1 === $table_tag) {
            $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Use tag');
            $useTag = [
                'name'        => "'usetag'",
                'title'       => "'{$language}USE_TAG'",
                'description' => "'{$language}USE_TAG_DESC'",
                'formtype'    => "'yesno'",
                'valuetype'   => "'int'",
                'default'     => '0',
            ];
            $ret .= $uCodeVConfig->getUserModVersionArray(2, $useTag, 'config');
        }
        $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Number column');
        $numbCol          = [
            'name'        => "'numb_col'",
            'title'       => "'{$language}NUMB_COL'",
            'description' => "'{$language}NUMB_COL_DESC'",
            'formtype'    => "'select'",
            'valuetype'   => "'int'",
            'default'     => '1',
            'options'     => "[1 => '1', 2 => '2', 3 => '3', 4 => '4']",
        ];
        $ret .= $uCodeVConfig->getUserModVersionArray(2, $numbCol, 'config');

        $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Divide by');
        $divideby         = [
            'name'        => "'divideby'",
            'title'       => "'{$language}DIVIDEBY'",
            'description' => "'{$language}DIVIDEBY_DESC'",
            'formtype'    => "'select'",
            'valuetype'   => "'int'",
            'default'     => '1',
            'options'     => "[1 => '1', 2 => '2', 3 => '3', 4 => '4']",
        ];
        $ret .= $uCodeVConfig->getUserModVersionArray(2, $divideby, 'config');

        $ret .= $phpCodeVConfig->getPhpCodeCommentLine('Table type');
        $tableType        = [
            'name'        => "'table_type'",
            'title'       => "'{$language}TABLE_TYPE'",
            'description' => "'{$language}DIVIDEBY_DESC'",
            'formtype'    => "'select'",
            'valuetype'   => "'int'",
            'default'     => "'bordered'",
            'options'     => "['bordered' => 'bordered', 'striped' => 'striped', 'hover' => 'hover', 'condensed' => 'condensed']",
        ];
        $ret              .= $uCodeVConfig->getUserModVersionArray(2, $tableType, 'config');

        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Panel by');
        $panelType        = [
            'name'        => "'panel_type'",
            'title'       => "'{$language}PANEL_TYPE'",
            'description' => "'{$language}PANEL_TYPE_DESC'",
            'formtype'    => "'select'",
            'valuetype'   => "'text'",
            'default'     => "'default'",
            'options'     => "['default' => 'default', 'primary' => 'primary', 'success' => 'success', 'info' => 'info', 'warning' => 'warning', 'danger' => 'danger']",
        ];
        $ret              .= $uCodeVConfig->getUserModVersionArray(2, $panelType, 'config');

        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Advertise');
        $advertise        = [
            'name'        => "'advertise'",
            'title'       => "'{$language}ADVERTISE'",
            'description' => "'{$language}ADVERTISE_DESC'",
            'formtype'    => "'textarea'",
            'valuetype'   => "'text'",
            'default'     => "''",
        ];
        $ret              .= $uCodeVConfig->getUserModVersionArray(2, $advertise, 'config');

        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Bookmarks');
        $bookmarks        = [
            'name'        => "'bookmarks'",
            'title'       => "'{$language}BOOKMARKS'",
            'description' => "'{$language}BOOKMARKS_DESC'",
            'formtype'    => "'yesno'",
            'valuetype'   => "'int'",
            'default'     => '0',
        ];
        $ret              .= $uCodeVConfig->getUserModVersionArray(2, $bookmarks, 'config');

        /*
         * removed, as there are no system templates in xoops core for fb or disqus comments
         * tdmcreate currently is also not creatings tpl files for this
        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Facebook Comments');
        $facebookComments = [
            'name'        => "'facebook_comments'",
            'title'       => "'{$language}FACEBOOK_COMMENTS'",
            'description' => "'{$language}FACEBOOK_COMMENTS_DESC'",
            'formtype'    => "'yesno'",
            'valuetype'   => "'int'",
            'default'     => '0',
        ];
        $ret              .= $uCodeVConfig->getUserModVersion(3, $facebookComments, 'config', '$c');
        $ret              .= $this->getSimpleString('++$c;');
        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Disqus Comments');
        $disqusComments   = [
            'name'        => "'disqus_comments'",
            'title'       => "'{$language}DISQUS_COMMENTS'",
            'description' => "'{$language}DISQUS_COMMENTS_DESC'",
            'formtype'    => "'yesno'",
            'valuetype'   => "'int'",
            'default'     => '0',
        ];
        $ret              .= $uCodeVConfig->getUserModVersion(3, $disqusComments, 'config', '$c');
        $ret              .= $this->getSimpleString('++$c;');
        */

        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Make Sample button visible?');
        $maintainedby     = [
            'name'        => "'displaySampleButton'",
            'title'       => "'CO_' . \$moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON'",
            'description' => "'CO_' . \$moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC'",
            'formtype'    => "'yesno'",
            'valuetype'   => "'int'",
            'default'     => '1',
        ];
        $ret              .= $uCodeVConfig->getUserModVersionArray(2, $maintainedby, 'config');

        $ret              .= $phpCodeVConfig->getPhpCodeCommentLine('Maintained by');
        $maintainedby     = [
            'name'        => "'maintainedby'",
            'title'       => "'{$language}MAINTAINEDBY'",
            'description' => "'{$language}MAINTAINEDBY_DESC'",
            'formtype'    => "'textbox'",
            'valuetype'   => "'text'",
            'default'     => "'{$module->getVar('mod_support_url')}'",
        ];
        $ret              .= $uCodeVConfig->getUserModVersionArray(2, $maintainedby, 'config');

        return $ret;
    }

    /**
     * @private function getNotificationsType
     * @param $language
     * @param $type
     * @param $tableName
     * @param $notifyFile
     * @param $item
     * @param $typeOfNotify
     *
     * @return string
     */
    private function getNotificationsType($language, $type, $tableName, $notifyFile, $item, $typeOfNotify)
    {
        $phpCodeNType    = Tdmcreate\Files\CreatePhpCode::getInstance();
        $uCodeNType      = UserXoopsCode::getInstance();
        $stuTableName    = mb_strtoupper($tableName);
        $stuTypeOfNotify = mb_strtoupper($typeOfNotify);
        $notifyFile      = explode(', ', $notifyFile);
        $notifyFile      = implode(', ', $notifyFile);
        $ret             = '';
        switch ($type) {
            case 'category':
                $ret      .= $phpCodeNType->getPhpCodeCommentLine('Category Notify');
                $category = [
                    'name'             => "'category'",
                    'title'            => "'{$language}{$stuTableName}_NOTIFY'",
                    'description'      => "'{$language}{$stuTableName}_NOTIFY_DESC'",
                    'subscribe_from'   => "['index.php',{$notifyFile}]",
                    'item_name'        => "'{$item}'",
                    "'allow_bookmark'" => '1',
                ];
                $ret      .= $uCodeNType->getUserModVersionArray(2, $category, 'notification', "'{$type}'");
                break;
            case 'event':
                $ret   .= $phpCodeNType->getPhpCodeCommentLine('Event Notify');
                $event = [
                    'name'          => "'{$typeOfNotify}'",
                    'category'      => "'{$tableName}'",
                    'admin_only'    => '1',
                    "'title'"       => "'{$language}{$stuTableName}_{$stuTypeOfNotify}_NOTIFY'",
                    'caption'       => "'{$language}{$stuTableName}_{$stuTypeOfNotify}_NOTIFY_CAPTION'",
                    'description'   => "'{$language}{$stuTableName}_{$stuTypeOfNotify}_NOTIFY_DESC'",
                    'mail_template' => "'{$tableName}_{$typeOfNotify}_notify'",
                    'mail_subject'  => "'{$language}{$stuTableName}_{$stuTypeOfNotify}_NOTIFY_SUBJECT'",
                ];
                $ret   .= $uCodeNType->getUserModVersionArray(2, $event, 'notification', "'{$type}'");
                break;
        }

        return $ret;
    }

    /**
     * @private function getXoopsVersionNotifications
     * @param $module
     * @param $language
     * @return string
     */
    private function getXoopsVersionNotifications($module, $language)
    {
        $uCodeVN       = UserXoopsCode::getInstance();
        $moduleDirname = $module->getVar('mod_dirname');
        $ret           = $this->getDashComment('Notifications');
        $ret           .= $uCodeVN->getUserModVersionText(1, 1, 'hasNotification');
        $notifications = ['lookup_file' => "'include/notification.inc.php'", 'lookup_func' => "'{$moduleDirname}_notify_iteminfo'"];
        $ret           .= $uCodeVN->getUserModVersionArray(1, $notifications, 'notification');

        $notifyFiles   = [];
        $single        = 'single';
        $tables        = $this->getTableTables($module->getVar('mod_id'), 'table_order');
        $tableCategory = [];
        $tableBroken   = [];
        $tableSubmit   = [];
        $tableId       = null;
        $tableMid      = null;
        foreach (array_keys($tables) as $t) {
            $tableId         = $tables[$t]->getVar('table_id');
            $tableMid        = $tables[$t]->getVar('table_mid');
            $tableName       = $tables[$t]->getVar('table_name');
            $tableSoleName   = $tables[$t]->getVar('table_solename');
            $tableCategory[] = $tables[$t]->getVar('table_category');
            $tableBroken[]   = $tables[$t]->getVar('table_broken');
            $tableSubmit[]   = $tables[$t]->getVar('table_submit');
            if (1 == $tables[$t]->getVar('table_notifications')) {
                //if ($t <= count($tableName)) {
                    $notifyFiles[] = $tableName;
                //}
            }
            if (1 == $tables[$t]->getVar('table_single')) {
                $single = $tableName;
            }
        }
        $fields      = $this->getTableFields($tableMid, $tableId);
        $fieldId     = null;
        $fieldParent = null;
        foreach (array_keys($fields) as $f) {
            $fieldName    = $fields[$f]->getVar('field_name');
            $fieldElement = $fields[$f]->getVar('field_element');
            if (0 == $f) {
                $fieldId = $fieldName;
            }
            if ($fieldElement > 15) {
                $fieldParent = $fieldName;
            }
        }

        $num = 1;
        $ret .= $this->getXoopsVersionNotificationGlobal($language, 'category', 'global', 'global', $notifyFiles, $num);
        ++$num;
        $ret .= $this->getXoopsVersionNotificationCategory($language, 'category', 'category', 'category', $notifyFiles, $fieldParent, '1', $num);
        ++$num;
        $ret .= $this->getXoopsVersionNotificationTableName($language, 'category', $tableSoleName, $tableSoleName, $single, $fieldId, 1, $num);
        unset($num);
        $num = 1;
        if (in_array(1, $tableCategory)) {
            $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'new_category', 'global', 0, 'global_new_category', $tableSoleName, 'global_newcategory_notify', $num);
            ++$num;
        }
        $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'modify', 'global', 1, 'global_modify', $tableSoleName, 'global_' . 'modify_notify', $num);
        if (in_array(1, $tableBroken)) {
            ++$num;
            $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'broken', 'global', 1, 'global_broken', $tableSoleName, 'global_' . 'broken_notify', $num);
        }
        if (in_array(1, $tableSubmit)) {
            ++$num;
            $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'submit', 'global', 1, 'global_submit', $tableSoleName, 'global_' . 'submit_notify', $num);
        }
        ++$num;
        $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'new_' . $tableSoleName, 'global', 0, 'global_new', $tableSoleName, 'global_new' . $tableSoleName . '_notify', $num);
        if (in_array(1, $tableCategory)) {
            ++$num;
            $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'submit', 'category', 1, 'category_submit', $tableSoleName, 'category_' . $tableSoleName . 'submit_notify', $num);
            ++$num;
            $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'new_category', 'category', 0, 'category', $tableSoleName, 'category_new' . $tableSoleName . '_notify', $num);
        }
        ++$num;
        $ret .= $this->getXoopsVersionNotificationCodeComplete($language, 'event', 'approve', $tableSoleName, 1, $tableSoleName, $tableSoleName, $tableSoleName . '_approve_notify', $num);
        unset($num);

        return $ret;
    }

    /**
     * @private function getXoopsVersionNotificationGlobal
     * @param $language
     * @param $type
     * @param $name
     * @param $title
     * @param $from
     *
     * @param $num
     * @return string
     */
    private function getXoopsVersionNotificationGlobal($language, $type, $name, $title, $from, $num)
    {
        $phpCodeVNG  = Tdmcreate\Files\CreatePhpCode::getInstance();
        $uCodeVNG    = UserXoopsCode::getInstance();
        $title       = mb_strtoupper($title);
        $implodeFrom = implode(".php', '", $from);
        $ret         = $phpCodeVNG->getPhpCodeCommentLine('Global Notify');
        $global      = [
            'name'           => "'{$name}'",
            'title'          => "{$language}{$title}_NOTIFY",
            'description'    => "{$language}{$title}_NOTIFY_DESC",
            'subscribe_from' => "['index.php', '{$implodeFrom}.php']",
        ];
        $ret         .= $uCodeVNG->getUserModVersionArray(3, $global, 'notification', "'{$type}'", $num);

        return $ret;
    }

    /**
     * @private function getXoopsVersionNotificationCategory
     * @param $language
     * @param $type
     * @param $name
     * @param $title
     * @param $file
     * @param $item
     * @param $allow
     * @param $num
     * @return string
     */
    private function getXoopsVersionNotificationCategory($language, $type, $name, $title, $file, $item, $allow, $num)
    {
        $phpCodeVNC = Tdmcreate\Files\CreatePhpCode::getInstance();
        $uCodeVNC   = UserXoopsCode::getInstance();
        $title      = mb_strtoupper($title);
        $impFile    = implode(".php', '", $file);
        $ret        = $phpCodeVNC->getPhpCodeCommentLine('Category Notify');
        $global     = [
            'name'           => "'{$name}'",
            'title'          => "{$language}{$title}_NOTIFY",
            'description'    => "{$language}{$title}_NOTIFY_DESC",
            'subscribe_from' => "['{$impFile}.php']",
            'item_name'      => "'{$item}'",
            'allow_bookmark' => (string)$allow,
        ];
        $ret        .= $uCodeVNC->getUserModVersionArray(3, $global, 'notification', "'{$type}'", $num);

        return $ret;
    }

    /**
     * @private function getXoopsVersionNotificationTableName
     * @param $language
     * @param $type
     * @param $name
     * @param $title
     * @param $file
     * @param $item
     * @param $allow
     *
     * @param $num
     * @return string
     */
    private function getXoopsVersionNotificationTableName($language, $type, $name, $title, $file, $item, $allow, $num)
    {
        $phpCodeVNTN = Tdmcreate\Files\CreatePhpCode::getInstance();
        $uCodeVNTN   = UserXoopsCode::getInstance();
        $stuTitle    = mb_strtoupper($title);
        $ucfTitle    = ucfirst($title);
        $ret         = $phpCodeVNTN->getPhpCodeCommentLine($ucfTitle . ' Notify');
        $table       = [
            'name'           => "'{$name}'",
            'title'          => "{$language}{$stuTitle}_NOTIFY",
            'description'    => "{$language}{$stuTitle}_NOTIFY_DESC",
            'subscribe_from' => "'{$file}.php'",
            'item_name'      => "'{$item}'",
            'allow_bookmark' => (string)$allow,
        ];
        $ret         .= $uCodeVNTN->getUserModVersionArray(3, $table, 'notification', "'{$type}'", $num);

        return $ret;
    }

    /**
     * @private function getXoopsVersionNotifications
     * @param $language
     * @param $type
     * @param $name
     * @param $category
     * @param $admin
     * @param $title
     * @param $table
     * @param $mail
     *
     * @param $num
     * @return string
     */
    private function getXoopsVersionNotificationCodeComplete($language, $type, $name, $category, $admin, $title, $table, $mail, $num)
    {
        $phpCodeVNCC = Tdmcreate\Files\CreatePhpCode::getInstance();
        $uCodeVNCC   = UserXoopsCode::getInstance();
        $title       = mb_strtoupper($title);
        $table       = mb_strtoupper($table);
        $ucfTitle    = ucfirst($title);
        $ret         = $phpCodeVNCC->getPhpCodeCommentLine($ucfTitle . ' Notify');
        $event       = [
            'name'          => "'{$name}'",
            'category'      => "'{$category}'",
            'admin_only'    => (string)$admin,
            'title'         => "{$language}{$title}_NOTIFY",
            'caption'       => "{$language}{$title}_NOTIFY_CAPTION",
            'description'   => "{$language}{$title}_NOTIFY_DESC",
            'mail_template' => "'{$mail}'",
            'mail_subject'  => "{$language}{$title}_NOTIFY_SUBJECT",
        ];
        $ret         .= $uCodeVNCC->getUserModVersionArray(3, $event, 'notification', "'{$type}'", $num);

        return $ret;
    }

    /**
     * @private function getXoopsVersionNotifications
     * @param $language
     * @param $type
     * @param $name
     * @param $category
     * @param $admin
     * @param $title
     * @param $table
     * @param $mail
     *
     * @param $num
     * @return string
     */
    private function getXoopsVersionSelectSizeMB($moduleDirname, $t = '')
    {
        $pc = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xc  = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $ucModuleDirname       = mb_strtoupper($moduleDirname);

        $ret  = $pc->getPhpCodeCommentLine('create increment steps for file size');
        $ret  .= $pc->getPhpCodeIncludeDir("__DIR__ . '/include/xoops_version.inc.php'", '',true,true);
        $ret  .= $xc->getXcEqualsOperator('$iniPostMaxSize      ', "{$moduleDirname}ReturnBytes(ini_get('post_max_size'))", null, false);
        $ret  .= $xc->getXcEqualsOperator('$iniUploadMaxFileSize', "{$moduleDirname}ReturnBytes(ini_get('upload_max_filesize'))", null, false);
        $ret  .= $xc->getXcEqualsOperator('$maxSize             ', "min(\$iniPostMaxSize, \$iniUploadMaxFileSize)", null, false);
        $cond = $xc->getXcEqualsOperator('$increment', '500', null, false,$t . "\t");
        $ret  .= $pc->getPhpCodeConditions('$maxSize', ' > ', '10000 * 1048576', $cond, false, $t);
        $cond = $xc->getXcEqualsOperator('$increment', '200', null, false,$t . "\t");
        $ret  .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '10000 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '100', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '5000 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '50', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '2500 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '10', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '1000 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '5', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '500 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '2', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '100 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '1', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '50 * 1048576', $cond, false, $t);
        $cond  = $xc->getXcEqualsOperator('$increment', '0.5', null, false,$t . "\t");
        $ret   .= $pc->getPhpCodeConditions('$maxSize', ' <= ', '25 * 1048576', $cond, false, $t);
        $ret   .= $xc->getXcEqualsOperator('$optionMaxsize', '[]');
        $ret   .= $xc->getXcEqualsOperator('$i', '$increment');
        $while = $xc->getXcEqualsOperator("\$optionMaxsize[\$i . ' ' . _MI_{$ucModuleDirname}_SIZE_MB]", '$i * 1048576', null, false,$t . "\t");
        $while .= $xc->getXcEqualsOperator('$i', '$increment', '+',false ,$t . "\t");
        $ret   .= $pc->getPhpCodeWhile('i * 1048576', $while, '$maxSize', ' <= ');

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
        $table         = $this->getTable();
        $tables        = $this->getTables();
        $filename      = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');
        $language      = $this->getLanguage($moduleDirname, 'MI');
        $content       = $this->getHeaderFilesComments($module, $filename);
        $content       .= $this->getXoopsVersionHeader($module, $language);
        $content       .= $this->getXoopsVersionTemplatesAdminUser($moduleDirname, $tables, $module->getVar('mod_admin'), $module->getVar('mod_user'));
        $content       .= $this->getXoopsVersionMySQL($moduleDirname, $table, $tables);
        $tableSearch        = [];
        $tableComments      = [];
        $tableSubmenu       = [];
        $tableBlocks        = [];
        $tableNotifications = [];
        foreach (array_keys($tables) as $t) {
            $tableSearch[]        = $tables[$t]->getVar('table_search');
            $tableComments[]      = $tables[$t]->getVar('table_comments');
            $tableSubmenu[]       = $tables[$t]->getVar('table_submenu');
            $tableBlocks[]        = $tables[$t]->getVar('table_blocks');
            $tableNotifications[] = $tables[$t]->getVar('table_notifications');
        }
        if (in_array(1, $tableSearch)) {
            $content .= $this->getXoopsVersionSearch($moduleDirname);
        }
        if (in_array(1, $tableComments)) {
            $content .= $this->getXoopsVersionComments($moduleDirname);
        }
        if (in_array(1, $tableSubmenu)) {
            $content .= $this->getXoopsVersionSubmenu($language, $tables);
        }
        if (in_array(1, $tableBlocks)) {
            $content .= $this->getXoopsVersionBlocks($moduleDirname, $tables, $language);
        }
        $content .= $this->getXoopsVersionConfig($module, $tables, $language);
        if (in_array(1, $tableNotifications)) {
            $content .= $this->getXoopsVersionNotifications($module, $language);
        }
        $this->create($moduleDirname, '/', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}

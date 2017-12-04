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
 * @version         $Id: TDMCreateMoreFiles.php 12258 2014-01-02 09:33:29Z timgno $
 */

/**
 * Class TDMCreateMoreFiles.
 */
class TDMCreateMoreFiles extends TDMCreateFile
{
    /**
    * @var mixed
    */
    private $folder = null;

    /**
    * @var mixed
    */
    private $extension = null;

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
     * @return TDMCreateMoreFiles
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
     * @param string $filename
     *
     * @param        $folder
     * @param        $extension
     * @return string
     */
    public function write($module, $filename, $folder, $extension)
    {
        $this->setModule($module);
        $this->extension = $extension;
        $this->setFileName($filename.'.'.$extension);
        if (strstr($folder, 'user')) {
            $this->folder = '/';
        } else {
            $this->folder = $folder;
        }
    }

    /**
     * @private function getMoreFilesPhp
     *
     * @param string $header
     * @return string
     */
    private function getMoreFilesPhp($header = '')
    {
        $ret = "<?php\n";
        $ret .= "{$header}\n";
        $ret .= $this->getInclude();
        $ret .= $this->getInclude('footer');

        return $ret;
    }

    /**
     * @private  function getMoreFilesTpl
     * @return string
     */
    private function getMoreFilesTpl()
    {
        $ret = "<div class=\"panel\">\n";
        $ret .= "\tPleace! put your template code here\n";
        $ret .= "</div>\n";

        return $ret;
    }

    /**
     * @private  function getMoreFilesHtml
     * @return string
     *
     */
    private function getMoreFilesHtml()
    {
        $ret = "<div class=\"panel\">\n";
        $ret .= "\tPleace! put your Html code here\n";
        $ret .= "</div>\n";

        return $ret;
    }

    /**
    *  @private function getMoreFilesText
    *  @param null
     *
     * @return string
     */
    private function getMoreFilesText()
    {
        return "# Pleace! put your text code here\n";
    }

    /**
    *  @private function getMoreFilesSql
    *  @param null
     *
     * @return string
     */
    private function getMoreFilesSql()
    {
        return "# Pleace! put your sql code here\n";
    }

    /**
    *  @private function getMoreFilesCss
    *  @param $header
     *
     * @return string
     */
    private function getMoreFilesCss($header = '')
    {
        $ret = "@charset \"UTF-8\"\n";
        $ret .= "{$header}\n\nPleace! put your css code here\n";

        return $ret;
    }

    /**
    *  @private function getMoreFilesDefault
    *  @param null
     *
     * @return string
     */
    private function getMoreFilesDefault()
    {
        return "Default File\n";
    }

    /**
     * @public   function render
     * @return bool|string
     */
    public function render()
    {
        $module = $this->getModule();
        $filename = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');
        $header = $this->getHeaderFilesComments($module, $filename, 0);
        switch ($this->extension) {
            case 'php':
                $content = $this->getMoreFilesPhp($header);
                break;
            case 'tpl':
                $content = $this->getMoreFilesTpl();
                break;
            case 'html':
                $content = $this->getMoreFilesHtml();
                break;
            case 'text':
                $content = $this->getMoreFilesText();
                break;
            case 'sql':
                $content = $this->getMoreFilesSql();
                break;
            case 'css':
                $content = $this->getMoreFilesCss($header);
                break;
            default:
                $content = $this->getMoreFilesDefault();
                break;
        }

        $this->create($moduleDirname, $this->folder, $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}

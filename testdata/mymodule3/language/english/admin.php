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
 * My Module 3 module for xoops
 *
 * @copyright     2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        mymodule3
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         TDM XOOPS - Email:<info@email.com> - Website:<http://xoops.org>
 */

include_once 'common.php';

// ---------------- Admin Index ----------------
define('_AM_MYMODULE3_STATISTICS', 'Statistics');
// There are
define('_AM_MYMODULE3_THEREARE_CATEGORIES', "There are <span class='bold'>%s</span> categories in the database");
define('_AM_MYMODULE3_THEREARE_ARTICLES', "There are <span class='bold'>%s</span> articles in the database");
define('_AM_MYMODULE3_THEREARE_TESTFIELDS', "There are <span class='bold'>%s</span> testfields in the database");
// ---------------- Admin Files ----------------
// There aren't
define('_AM_MYMODULE3_THEREARENT_CATEGORIES', "There aren't categories");
define('_AM_MYMODULE3_THEREARENT_ARTICLES', "There aren't articles");
define('_AM_MYMODULE3_THEREARENT_TESTFIELDS', "There aren't testfields");
// Save/Delete
define('_AM_MYMODULE3_FORM_OK', 'Successfully saved');
define('_AM_MYMODULE3_FORM_DELETE_OK', 'Successfully deleted');
define('_AM_MYMODULE3_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
define('_AM_MYMODULE3_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Buttons
define('_AM_MYMODULE3_ADD_CATEGORY', 'Add New Category');
define('_AM_MYMODULE3_ADD_ARTICLE', 'Add New Article');
define('_AM_MYMODULE3_ADD_TESTFIELD', 'Add New Testfield');
// Lists
define('_AM_MYMODULE3_CATEGORIES_LIST', 'List of Categories');
define('_AM_MYMODULE3_ARTICLES_LIST', 'List of Articles');
define('_AM_MYMODULE3_TESTFIELDS_LIST', 'List of Testfields');
// ---------------- Admin Classes ----------------
// Category add/edit
define('_AM_MYMODULE3_CATEGORY_ADD', 'Add Category');
define('_AM_MYMODULE3_CATEGORY_EDIT', 'Edit Category');
// Elements of Category
define('_AM_MYMODULE3_CATEGORY_ID', 'Id');
define('_AM_MYMODULE3_CATEGORY_NAME', 'Name');
define('_AM_MYMODULE3_CATEGORY_LOGO', 'Logo');
define('_AM_MYMODULE3_CATEGORY_LOGO_UPLOADS', 'Logo in %s :');
define('_AM_MYMODULE3_CATEGORY_CREATED', 'Created');
define('_AM_MYMODULE3_CATEGORY_SUBMITTER', 'Submitter');
// Article add/edit
define('_AM_MYMODULE3_ARTICLE_ADD', 'Add Article');
define('_AM_MYMODULE3_ARTICLE_EDIT', 'Edit Article');
// Elements of Article
define('_AM_MYMODULE3_ARTICLE_ID', 'Id');
define('_AM_MYMODULE3_ARTICLE_CAT', 'Categories');
define('_AM_MYMODULE3_ARTICLE_TITLE', 'Title');
define('_AM_MYMODULE3_ARTICLE_DESCR', 'Descr');
define('_AM_MYMODULE3_ARTICLE_IMG', 'Img');
define('_AM_MYMODULE3_ARTICLE_IMG_UPLOADS', 'Img in %s :');
define('_AM_MYMODULE3_ARTICLE_ONLINE', 'Online');
define('_AM_MYMODULE3_ARTICLE_FILE', 'File');
define('_AM_MYMODULE3_ARTICLE_FILE_UPLOADS', 'File in %s :');
define('_AM_MYMODULE3_ARTICLE_CREATED', 'Created');
define('_AM_MYMODULE3_ARTICLE_SUBMITTER', 'Submitter');
// Testfield add/edit
define('_AM_MYMODULE3_TESTFIELD_ADD', 'Add Testfield');
define('_AM_MYMODULE3_TESTFIELD_EDIT', 'Edit Testfield');
// Elements of Testfield
define('_AM_MYMODULE3_TESTFIELD_ID', 'Id');
define('_AM_MYMODULE3_TESTFIELD_TEXT', 'Text');
define('_AM_MYMODULE3_TESTFIELD_TEXTAREA', 'Textarea');
define('_AM_MYMODULE3_TESTFIELD_DHTML', 'Dhtml');
define('_AM_MYMODULE3_TESTFIELD_CHECKBOX', 'Checkbox');
define('_AM_MYMODULE3_TESTFIELD_YESNO', 'Yesno');
define('_AM_MYMODULE3_TESTFIELD_SELECTBOX', 'Selectbox');
define('_AM_MYMODULE3_TESTFIELD_USER', 'User');
define('_AM_MYMODULE3_TESTFIELD_COLOR', 'Color');
define('_AM_MYMODULE3_TESTFIELD_IMAGELIST', 'Imagelist');
define('_AM_MYMODULE3_TESTFIELD_IMAGELIST_UPLOADS', 'Imagelist in frameworks images: %s');
define('_AM_MYMODULE3_TESTFIELD_URLFILE', 'Urlfile');
define('_AM_MYMODULE3_TESTFIELD_URLFILE_UPLOADS', 'Urlfile in uploads');
define('_AM_MYMODULE3_TESTFIELD_UPLIMAGE', 'Uplimage');
define('_AM_MYMODULE3_TESTFIELD_UPLIMAGE_UPLOADS', 'Uplimage in %s :');
define('_AM_MYMODULE3_TESTFIELD_UPLFILE', 'Uplfile');
define('_AM_MYMODULE3_TESTFIELD_UPLFILE_UPLOADS', 'Uplfile in %s :');
define('_AM_MYMODULE3_TESTFIELD_TEXTDATESELECT', 'Textdateselect');
define('_AM_MYMODULE3_TESTFIELD_SELECTFILE', 'Selectfile');
define('_AM_MYMODULE3_TESTFIELD_SELECTFILE_UPLOADS', 'Selectfile in %s :');
define('_AM_MYMODULE3_TESTFIELD_PASSWORD', 'Password');
define('_AM_MYMODULE3_TESTFIELD_COUNTRY_LIST', 'SelectCountry');
define('_AM_MYMODULE3_TESTFIELD_LANGUAGE', 'SelectLang');
define('_AM_MYMODULE3_TESTFIELD_RADIO', 'Radio');
define('_AM_MYMODULE3_TESTFIELD_STATUS', 'Status');
define('_AM_MYMODULE3_TESTFIELD_DATETIME', 'DateTime');
define('_AM_MYMODULE3_TESTFIELD_COMBOBOX', 'SelectCombo');
// General
define('_AM_MYMODULE3_FORM_UPLOAD', 'Upload file');
define('_AM_MYMODULE3_FORM_UPLOAD_NEW', 'Upload new file: ');
define('_AM_MYMODULE3_FORM_UPLOAD_SIZE', 'Max file size: ');
define('_AM_MYMODULE3_FORM_UPLOAD_SIZE_MB', 'MB');
define('_AM_MYMODULE3_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
define('_AM_MYMODULE3_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
define('_AM_MYMODULE3_FORM_IMAGE_PATH', 'Files in %s :');
define('_AM_MYMODULE3_FORM_ACTION', 'Action');
define('_AM_MYMODULE3_FORM_EDIT', 'Modification');
define('_AM_MYMODULE3_FORM_DELETE', 'Clear');
// Status
define('_AM_MYMODULE3_STATUS_NONE', 'No status');
define('_AM_MYMODULE3_STATUS_OFFLINE', 'Offline');
define('_AM_MYMODULE3_STATUS_SUBMITTED', 'Submitted');
define('_AM_MYMODULE3_STATUS_APPROVED', 'Approved');
// Sample List Values
define('_AM_MYMODULE3_LIST_1', 'Sample List Value 1');
define('_AM_MYMODULE3_LIST_2', 'Sample List Value 2');
define('_AM_MYMODULE3_LIST_3', 'Sample List Value 3');
// ---------------- Admin Permissions ----------------
// Permissions
define('_AM_MYMODULE3_PERMISSIONS_GLOBAL', 'Permissions global');
define('_AM_MYMODULE3_PERMISSIONS_GLOBAL_DESC', 'Permissions global to check type of.');
define('_AM_MYMODULE3_PERMISSIONS_GLOBAL_4', 'Permissions global to approve');
define('_AM_MYMODULE3_PERMISSIONS_GLOBAL_8', 'Permissions global to submit');
define('_AM_MYMODULE3_PERMISSIONS_GLOBAL_16', 'Permissions global to view');
define('_AM_MYMODULE3_PERMISSIONS_APPROVE', 'Permissions to approve');
define('_AM_MYMODULE3_PERMISSIONS_APPROVE_DESC', 'Permissions to approve');
define('_AM_MYMODULE3_PERMISSIONS_SUBMIT', 'Permissions to submit');
define('_AM_MYMODULE3_PERMISSIONS_SUBMIT_DESC', 'Permissions to submit');
define('_AM_MYMODULE3_PERMISSIONS_VIEW', 'Permissions to view');
define('_AM_MYMODULE3_PERMISSIONS_VIEW_DESC', 'Permissions to view');
define('_AM_MYMODULE3_NO_PERMISSIONS_SET', 'No permission set');
// ---------------- Admin Others ----------------
define('_AM_MYMODULE3_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------

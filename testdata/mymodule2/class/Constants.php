<?php

namespace XoopsModules\Mymodule2;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * My Module 2 module for xoops
 *
 * @copyright     2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        mymodule2
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         TDM XOOPS - Email:<info@email.com> - Website:<http://xoops.org>
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class  Constants
 */
class Constants
{
	// Constants for status
	const STATUS_NONE      = 0;
	const STATUS_OFFLINE   = 1;
	const STATUS_SUBMITTED = 2;
	const STATUS_APPROVED  = 3;

	// Constants for permissions
	const PERM_GLOBAL_NONE    = 0;
	const PERM_GLOBAL_VIEW    = 1;
	const PERM_GLOBAL_SUBMIT  = 2;
	const PERM_GLOBAL_APPROVE = 3;

}

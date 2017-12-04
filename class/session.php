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
 *  TDMCreate class.
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 *
 * @since           1.0
 *
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Harry Fuecks (PHP Anthology Volume II)
 *
 * @version         $Id: 1.91 session.php 12453 2014-03-28 18:34:46Z timgno $
 */

/**
 * Class TDMCreateSession.
 */
class TDMCreateSession
{
    /**
     * Session constructor<br />
     * Starts the session with session_start()
     * <strong>Note:</strong> that if the session has already started,
     * session_start() does nothing.
     */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /*
    *  @static function getInstance
    *  @param null
    */
    /**
     * @return bool
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!isset($instance)) {
            $class = __CLASS__;
            $instance = new $class();
        }

        return $instance;
    }

    /**
     * Sets a session variable.
     *
     * @param string $name  name of variable
     * @param mixed  $value value of variable
     */
    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Fetches a session variable.
     *
     * @param string $name name of variable
     *
     * @return mixed value of session variable
     */
    public function getSession($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return false;
        }
    }

    /**
     * Deletes a session variable.
     *
     * @param string $name name of variable
     */
    public function deleteSession($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Destroys the whole session.
     */
    public function destroySession()
    {
        $_SESSION = [];
        session_destroy();
    }
}

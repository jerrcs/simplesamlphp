<?php

/**
 * This file is part of SimpleSAMLphp. See the file COPYING in the
 * root of the distribution for licence information.
 *
 * This file defines a session handler which uses the default php
 * session handler for storage.
 *
 * @author Olav Morken, UNINETT AS. <andreas.solberg@uninett.no>
 * @package simpleSAMLphp
 * @version $Id$
 */
class SimpleSAML_SessionHandlerPHP extends SimpleSAML_SessionHandler {

	/* Initialize the PHP session handling. This constructor is protected
	 * because it should only be called from
	 * SimpleSAML_SessionHandler::createSessionHandler(...).
	 */
	protected function __construct() {

		/* Call the parent constructor in case it should become
		 * necessary in the future.
		 */
		parent::__construct();

		/* Initialize the php session handling.
		 *
		 * If session_id() returns a blank string, then we need
		 * to call session start. Otherwise the session is already
		 * started, and we should avoid calling session_start().
		 */
		if(session_id() === '') {
			$config = SimpleSAML_Configuration::getInstance();

			$params = $this->getCookieParams();

			$version = explode('.', PHP_VERSION);
			if ((int)$version[0] === 5 && (int)$version[1] < 2) {
				session_set_cookie_params($params['lifetime'], $params['path'], $params['domain'], $params['secure']);
			} else {
				session_set_cookie_params($params['lifetime'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
			}

			$cookiename = $config->getString('session.phpsession.cookiename', NULL);
			if (!empty($cookiename)) session_name($cookiename);

			$savepath = $config->getString('session.phpsession.savepath', NULL);
			if(!empty($savepath)) {
				session_save_path($savepath);
			}

			if(!array_key_exists(session_name(), $_COOKIE)) {

				if (headers_sent()) {
					throw new SimpleSAML_Error_Exception('Cannot create new session - headers already sent.');
				}

				/* Session cookie unset - session id not set. Generate new (secure) session id. */
				session_id(SimpleSAML_Utilities::stringToHex(SimpleSAML_Utilities::generateRandomBytes(16)));
			}
			
			session_start();
		}
	}


	/* This function retrieves the session id of the current session.
	 *
	 * Returns:
	 *  The session id of the current session.
	 */
	public function getSessionId() {
		return session_id();
	}


	/* This function is used to store data in this session object.
	 *
	 * See the information in SimpleSAML_SessionHandler::set(...) for
	 * more information.
	 */
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}


	/* This function retrieves a value from this session object.
	 *
	 * See the information in SimpleSAML_SessionHandler::get(...) for
	 * more information.
	 */
	public function get($key) {
		/* Check if key exists first to avoid notice-messages in the
		 * log.
		 */
		if (!isset($_SESSION)) return NULL;
		if(!array_key_exists($key, $_SESSION)) {
			/* We should return NULL if we don't have that
			 * key in the session.
			 */
			return NULL;
		}

		return $_SESSION[$key];
	}


	/**
	 * Check whether the session cookie is set.
	 *
	 * This function will only return FALSE if is is certain that the cookie isn't set.
	 *
	 * @return bool  TRUE if it was set, FALSE if not.
	 */
	public function hasSessionCookie() {

		$cookieName = session_name();
		return array_key_exists($cookieName, $_COOKIE);
	}


	/**
	 * Get the cookie parameters that should be used for session cookies.
	 *
	 * This function contains some adjustments from the default to provide backwards-compatibility.
	 *
	 * @return array
	 * @link http://www.php.net/manual/en/function.session-get-cookie-params.php
	 */
	public function getCookieParams() {

		$config = SimpleSAML_Configuration::getInstance();

		$ret = parent::getCookieParams();

		if ($config->hasValue('session.phpsession.limitedpath') && $config->hasValue('session.cookie.path')) {
			throw new SimpleSAML_Error_Exception('You cannot set both the session.phpsession.limitedpath and session.cookie.path options.');
		} elseif ($config->hasValue('session.phpsession.limitedpath')) {
			$ret['path'] = $config->getBoolean('session.phpsession.limitedpath', FALSE) ? '/' . $config->getBaseURL() : '/';
		}

		$ret['httponly'] = $config->getBoolean('session.phpsession.httponly', FALSE);

		return $ret;
	}

}

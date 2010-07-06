<?php

$config = array(

	'example-sql' => array(
		'sqlauth:SQL',
		'dsn' => 'pgsql:host=sql.example.org;port=5432;dbname=simplesaml',
		'username' => 'simplesaml',
		'password' => 'secretpassword',
		'query' => 'SELECT "username", "name", "email" FROM "users" WHERE "username" = :username AND "password" = :password',
	),

	'example-static' => array(
		'exampleauth:Static',
		'uid' => array('testuser'),
		'eduPersonAffiliation' => array('member', 'employee'),
		'cn' => array('Test User'),
	),
	
	// Requires you to enable the OpenID module.
	'openid' => array(
		'openid:OpenIDConsumer',
	),

	'example-userpass' => array(
		'exampleauth:UserPass',
		'student:studentpass' => array(
			'uid' => array('test'),
			'eduPersonAffiliation' => array('member', 'student'),
		),
		'employee:employeepass' => array(
			'uid' => array('employee'),
			'eduPersonAffiliation' => array('member', 'employee'),
		),
	),
	
	'yubikey' => array(
		'authYubiKey:YubiKey',
 		'id' => '000',
// 		'key' => '012345678',
	),
	
	'openid' => array(
		'openid:OpenIDConsumer',
	),

	'feide' => array(
		'feide:Feide',
	),
	
	'papi' => array(
		'authpapi:PAPI',
	),
	
	'saml2' => array(
		'saml2:SP',
	),
	
	'facebook' => array(
		'authfacebook:Facebook',
		'api_key' => 'xxxxxxxxxxxxxxxx',
		'secret' => 'xxxxxxxxxxxxxxxx',
	),
        
	/* Example of a LDAP authentication source. */
	'example-ldap' => array(
		'ldap:LDAP',

		/* The hostname of the LDAP server. */
		'hostname' => 'ldap.example.org',

		/* Whether SSL/TLS should be used when contacting the LDAP server. */
		'enable_tls' => FALSE,

		/*
		 * Which attributes should be retrieved from the LDAP server.
		 * This can be an array of attribute names, or NULL, in which case
		 * all attributes are fetched.
		 */
		'attributes' => NULL,

		/*
		 * The pattern which should be used to create the users DN given the username.
		 * %username% in this pattern will be replaced with the users username.
		 *
		 * This option is not used if the search.enable option is set to TRUE.
		 */
		'dnpattern' => 'uid=%username%,ou=people,dc=example,dc=org',

		/*
		 * As an alternative to specifying a pattern for the users DN, it is possible to
		 * search for the username in a set of attributes. This is enabled by this option.
		 */
		'search.enable' => FALSE,

		/*
		 * The DN which will be used as a base for the search.
		 * This can be a single string, in which case only that DN is searched, or an
		 * array of strings, in which case they will be searched in the order given.
		 */
		'search.base' => 'ou=people,dc=example,dc=org',

		/*
		 * The attribute(s) the username should match against.
		 *
		 * This is an array with one or more attribute names. Any of the attributes in
		 * the array may match the value the username.
		 */
		'search.attributes' => array('uid', 'mail'),

		/*
		 * The username & password the simpleSAMLphp should bind to before searching. If
		 * this is left as NULL, no bind will be performed before searching.
		 */
		'search.username' => NULL,
		'search.password' => NULL,
	),

	/* Example of an LDAPMulti authentication source. */
	'example-ldapmulti' => array(
		'ldap:LDAPMulti',

		/*
		 * A list of available LDAP servers / user groups. The value of each element is
		 * an array in the same format as an LDAP authentication source.
		 */
		'employees' => array(
			/*
			 * A short name/description for this group. Will be shown in a dropdown list
			 * when the user logs on.
			 *
			 * This option can be a string or an array with language => text mappings.
			 */
			'description' => 'Employees',

			/*
			 * The rest of the options are the same as those available for
			 * the LDAP authentication source.
			 */
			'hostname' => 'ldap.employees.example.org',
			'dnpattern' => 'uid=%username%,ou=employees,dc=example,dc=org',
		),

		'students' => array(
			'description' => 'Students',

			'hostname' => 'ldap.students.example.org',
			'dnpattern' => 'uid=%username%,ou=students,dc=example,dc=org',
		),

	),

);

?>
<?php
/**
 * Database configuration
 */
define('DB_USERNAME', 'testing_db');
define('DB_PASSWORD', 'kagawa26');
define('DB_HOST', 'localhost');
define('DB_NAME', 'testing_db');

/* Site URL Config */
define('SITE_URL', 'http://facilitiesdesk.tulabyte.net');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);

/* Brand ID */
define('SHORTNAME', 'Testing');
define('LONGNAME', 'FacilitiesDesk Application Suite');

/*Site Email*/
define('FROM_EMAIL', 'info@tulabyte.net');

/*Hash Secret*/
define('FHS', 'rTxNwwoPaq14smONPKdl');

/*Login Token Lifetime*/
define('LOGIN_TOKEN_LIFETIME', '+24 hour');

/*Public URLS Allowed - No Auth*/
// define('PUBLIC_ROUTES', ['\/userLogin', '\/userSignup']);

/* SMS Parameters */
/*define('SMS_CMD', 'sendquickmsg');
define('SMS_OWNEREMAIL', 'yemgab@yahoo.com');
define('SMS_SUBACCT', 'TRENOVA');
define('SMS_SUBACCTPWD', 'trenova1720');
define('SMS_SENDER', 'TRENOVA');
*/


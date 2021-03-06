<?php

/**
 * APPLICATION
 */
define('CONF_BASE_URL', 'http://localhost:8080/gamenews/backend/');

/**
 * DATABASE
 */
define('CONF_DB_HOST', 'localhost');
define('CONF_DB_NAME', 'gamenews');
define('CONF_DB_USER', 'root');
define('CONF_DB_PASSWORD', '');


/**
 * API
 */
define('CONF_API_ALLOW_ORIGIN', '*');
define('CONF_API_CONTENT_TYPE', 'application/json');
define('CONF_API_CHARSET', 'utf-8');
define('CONF_API_ALLOW_METHODS', ["GET", "POST", "PUT", "DELETE", "OPTIONS", "PATCH"]);
define('CONF_API_MAX_AGE', '3600');
define('CONF_API_ALLOW_HEADERS', ["Origin", "Content-Type", "Access-Controll-Allow-Headers", "Authorization"]);
<?php

/**
 * WordPress configuration that I don't want blown away on every deployment.
 *
 * This file lives in our public Git repo, so for the love of God, don't put any
 * sensitive credentials in here!
 */

// Make WordPress cookies available on all BlogNomic subdomains,
// so tools like the die roller can check the session.
$host_parts = explode('.', $_SERVER['HTTP_HOST']);
$host_parts = array_slice($host_parts, -2);
$cookie_domain = '.' . implode('.', $host_parts);
define('COOKIE_DOMAIN', $cookie_domain);

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
//define('WP_DEBUG', true);

define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

/**
 * Removing this could cause issues with your experience in the DreamHost panel
 */

if (preg_match("/^(.*)\.dream\.website$/", $_SERVER['HTTP_HOST'])) {
  $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
  define('WP_SITEURL', $proto . '://' . $_SERVER['HTTP_HOST']);
  define('WP_HOME',    $proto . '://' . $_SERVER['HTTP_HOST']);
}

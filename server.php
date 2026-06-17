<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 * This file is used by the built-in PHP development server.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the request is for a static file that exists, let the server handle it.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
?>

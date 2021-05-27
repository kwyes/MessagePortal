<?php
/**
 * @author Bryan Lee <yeebwn@gmail.com>
 */

require_once __DIR__.'/settings.php';
global $settings;

if($settings['env'] != 'production') {
    phpinfo();
} else {
    header("HTTP/1.0 404 Not Found");
}

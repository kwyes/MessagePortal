<?php
session_start();
session_destroy();

require_once __DIR__.'/settings.php';
require_once __DIR__.'/lib/auth.php';

global $settings;
new Auth($settings);

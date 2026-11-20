<?php
date_default_timezone_set('UTC');
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils/exceptions.php';
require_once __DIR__ . '/utils/Logger.php';
foreach (['User', 'Category', 'Trainer', 'Class', 'Membership', 'Booking', 'UserMembership', 'Weather'] as $name) {
    require_once __DIR__ . '/services/' . $name . 'Service.php';
}

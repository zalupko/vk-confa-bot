<?php
use Core\Utils\RuntimeTracker;
require_once('core/utils/autoloader.php');
RuntimeTracker::removeIdentifier();
echo 'Removed RuntimeTracker... Now what?'.PHP_EOL;
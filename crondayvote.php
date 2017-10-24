<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once __DIR__ . '/autoload.php';

use App\Models\Votes;

$clean = Votes::cleanDayVotes();

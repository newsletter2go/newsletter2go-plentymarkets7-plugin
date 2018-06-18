<?php
$confirmed = new DateTime(0);
$string = date_format($confirmed, 'Y-m-d H:i:s');

var_dump($string);

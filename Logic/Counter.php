<?php
/**
 * Created by PhpStorm.
 * User: Toole
 * Date: 29.03.2019
 * Time: 9:38
 *
 *
 * @param $counter int
 */

$counter = isset($_COOKIE['counter']) ? $_COOKIE['counter'] : 0;
$counter++;
setcookie("counter", $counter, 0);
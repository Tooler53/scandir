<?php
/**
 * Created by PhpStorm.
 * User: Toole
 * Date: 29.03.2019
 * Time: 12:55
 *
 * @param $sql object
 */

require_once "ScanDir.php";
$sql = new ScanDir();
$sql->scan();

header('Location: /index.php');
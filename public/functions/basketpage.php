<?php
/**
 * Created by PhpStorm.
 * User: hilton
 * Date: 24/3/2017
 * Time: 11:42 AM
 */

if($_GET['rid']){
    header('Location: https://'.$_SERVER['HTTP_HOST'].'/recipe-print-fix/'.$_GET['rid']);
    exit;
}
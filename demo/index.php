<?php

use Core\Classes\SimpleMathCaptcha;

require_once __DIR__ . '/../vendor/autoload.php';

$simpleCaptcha = new SimpleMathCaptcha();

//$simpleCaptcha->setTextColor(21,87,36);
//$simpleCaptcha->setBackgroundColor(212,237,217);
//$simpleCaptcha->setFont('iransans');

//$simpleCaptcha->getAnswer();

$simpleCaptcha->output();

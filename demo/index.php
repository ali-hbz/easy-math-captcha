<?php

use Core\Classes\EasyMathCaptcha;

require_once __DIR__ . '/../vendor/autoload.php';

$captcha = new EasyMathCaptcha();

//$captcha->setTextColor(21,87,36);
//$captcha->setBackgroundColor(212,237,217);
//$captcha->setFont('iransans');

//$captcha->getAnswer();

$captcha->output();

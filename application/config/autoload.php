<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array('database','session','pagination', 'xmlrpc' , 'form_validation', 'email','upload', 'cart', 'img_resize');
$autoload['drivers'] = array();
$autoload['helper'] = array('url','file','form','security','string','inflector','directory','download','captcha', 'language', 'date', 'mac', 'breadcrumb');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array('general', 'emails', 'user_account', 'wallet', 'support', 'matrix2x', 'matrix3x', 'commissions', 'returns', 'dashboards', 'kyc_model', 'sms');

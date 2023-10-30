<?php
defined('BASEPATH') or exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('database', 'session', 'form_validation', 'Email_sender');

$autoload['drivers'] = array('session');

$autoload['helper'] = array('url', 'file', 'security', 'text');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array();

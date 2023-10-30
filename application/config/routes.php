<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Restfull';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['update-data'] = 'Import/getExcel';
$route['post-update-data'] = 'Import/importExcel';
$route['send-code-data'] = 'Import/send_kode';
$route['batal/(:any)'] = 'Import/batal/$1';

$route['success'] = 'Restfull/success';

$route['get/cabang/ksm'] = 'Restfull/get_cabang';
$route['get/cabang/ksm/(:num)'] = 'Restfull/get_result_cabang/$1';
$route['post/cabang/ksm/(:num)'] = 'Restfull/search_kl/$1';

$route['post/posting-report'] = 'Restfull/reporting';

<?php

$routes->group('tools', ['namespace' => '\Ci4toolsadmin\Controllers'], function ($routes) {
  $routes->cli('install',               'Tools::install');
  $routes->cli('tableinfo/(:any)',      'Tools::tableinfo/$1');
  $routes->cli('create/(:any)',         'Tools::create/$1');
  $routes->cli('make/(:any)',           'Tools::make/$1');
  $routes->cli('config/(:any)',         'Tools::config/$1');
  $routes->get('visiblefields/(:any)',  'Tools::getVisibleFields/$1');
});

$routes->group('admin', ['namespace' => '\Ci4toolsadmin\Controllers'], function ($routes) {
  $routes->get('/',                     'Dashboard::index');
  $routes->get('dashboard',             'Dashboard::index');
  $routes->get('table/(:any)',          'Table::index/$1');
  $routes->post('table/saveconfig',     'Table::saveconfig');
  $routes->get('controller',            'Controller::index');
});
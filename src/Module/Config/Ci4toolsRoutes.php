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

//$routes->group('sistema', function($routes) {
  $routes->get('home',                  'Home::index');

  $routes->get('dashboard',             'Dashboard::index');

  $routes->get('carteira',              'Carteira::index');
  $routes->get('carteira/list',         'Carteira::list');
  $routes->get('carteira/new',          'Carteira::new');
  $routes->get('carteira/edit/(:num)',  'Carteira::edit/$1');
  $routes->post('carteira/store',       'Carteira::store');

  $routes->get('pda',                   'Pda::index');
  $routes->get('pda/list',              'Pda::list');
  $routes->get('pda/new',               'Pda::new');
  $routes->get('pda/edit/(:num)',       'Pda::edit/$1');
  $routes->post('pda/store',            'Pda::store');
//});
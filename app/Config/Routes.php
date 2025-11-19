<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
require APPPATH . 'Config/RoutesCrud.php';

$routes->set404Override(function() {
  $viewData['message'] = 'Page not found.';
  return view('errors/html/error_404',$viewData);
});

$routes->get('/', 'Index::index');
$routes->get('login', 'Auth::index');
$routes->post('doLogin', 'Auth::login');

$routes->group('/', ['filter' => 'auth'], static function ($routes) {
  $routes->get('logout', 'Auth::logout');

  $routes->group('profile', [], static function ($routes) {
    $routes->get('/', 'Index::getUserProfile');
    $routes->post('/', 'Index::saveUserProfile');
    $routes->get('group', 'Index::getUserProfileGroup');
    $routes->post('group', 'Index::switchUserProfileGroup');
  });
  
  $routes->get('home', 'Index::home');

  $routes->group('user', ['filter' => 'privilege:user'], static function ($routes) {
    $routes->get('/', 'User::index');
    $routes->get('(:segment)/get', 'User::getData/$1');
    $routes->post('add', 'User::add');
    $routes->post('(:segment)/edit', 'User::edit/$1');
    $routes->post('(:segment)/delete', 'User::delete/$1');
  });

  $routes->group('group', ['filter' => 'privilege:group'], static function ($routes) {
    $routes->get('/', 'Group::index');
    $routes->get('(:segment)/get', 'Group::getData/$1');
    $routes->post('add', 'Group::add');
    $routes->post('(:segment)/edit', 'Group::edit/$1');
    $routes->post('(:segment)/delete', 'Group::delete/$1');
    $routes->get('(:segment)/detailModal', 'Group::detailModal/$1');
  });
  
  $routes->group('pasien', [], function ($routes) {
    $routes->get('', 'Pasien::index');
    $routes->get('(:segment)/get', 'Pasien::getData/$1');
    $routes->post('save', 'Pasien::save');
    $routes->post('(:segment)/delete', 'Pasien::delete/$1');
    $routes->get('(:segment)/detailModal', 'Pasien::detailModal/$1');
    $routes->post('importJson', 'Pasien::importJson');
  });
  $routes->group('pendaftaran', [], function ($routes) {
    $routes->get('', 'Pendaftaran::index');
    $routes->get('(:segment)/get', 'Pendaftaran::getData/$1');
    $routes->post('save', 'Pendaftaran::save');
    $routes->post('(:segment)/delete', 'Pendaftaran::delete/$1');
    $routes->get('(:segment)/detailModal', 'Pendaftaran::detailModal/$1');
  });
  $routes->group('kunjungan', [], function ($routes) {
    $routes->get('', 'Kunjungan::index');
    $routes->get('(:segment)/get', 'Kunjungan::getData/$1');
    $routes->post('save', 'Kunjungan::save');
    $routes->post('(:segment)/delete', 'Kunjungan::delete/$1');
    $routes->get('(:segment)/detailModal', 'Kunjungan::detailModal/$1');
  });
  $routes->group('asesmen', [], function ($routes) {
    $routes->get('', 'Asesmen::index');
    $routes->get('(:segment)/get', 'Asesmen::getData/$1');
    $routes->post('save', 'Asesmen::save');
    $routes->post('(:segment)/delete', 'Asesmen::delete/$1');
    $routes->get('(:segment)/detailModal', 'Asesmen::detailModal/$1');
  });
});
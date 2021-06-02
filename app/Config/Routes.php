<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::dashboard');
$routes->delete('/children/(:num)', 'ChildrenController::delete/$1');
$routes->get('/children','ChildrenController::index');
$routes->get('/children/edit/(:num)','ChildrenController::edit/$1');
$routes->get('/children/add','ChildrenController::addChildren');
$routes->post('/children/insert','ChildrenController::insert'); 
$routes->put('/children/update/(:num)','ChildrenController::update/$1');
$routes->get('/children/export','ChildrenController::export');


$routes->delete('/pembimbing/(:num)','PembimbingController::delete/$1');
$routes->get('/pembimbing','PembimbingController::index');
$routes->get('/pembimbing/search','PembimbingController::searchPembimbings');
$routes->get('/pembimbing/add','PembimbingController::create');
$routes->post('/pembimbing/insert','PembimbingController::insert');
$routes->get('/pembimbing/edit/(:num)','PembimbingController::edit/$1');
$routes->put('/pembimbing/update/(:num)','PembimbingController::update/$1');
$routes->get('/pembimbing/export','PembimbingController::export');

$routes->delete('/absensi/(:num)', "AbsensiController::delete/$1");
$routes->get('/absensi','AbsensiController::index');
$routes->get('/absensi/search','AbsensiController::searchData');
$routes->get('/absensi/add','AbsensiController::addAbsensi');
$routes->get('/absensi/getChildPembimbing/(:num)', 'AbsensiController::getAbsensiByPembimbing/$1');
$routes->post('/absensi/insert',"AbsensiController::insert");
$routes->get('/absensi/edit/(:num)', "AbsensiController::edit/$1");
$routes->put('/absensi/update/(:num)', "AbsensiController::update/$1");

$routes->get('/history',"AbsensiController::history");
$routes->get('/history/search/(:any)', "AbsensiController::searchHistory/$1");
$routes->get('/history/searchall', "AbsensiController::searchAll");
$routes->get('/export/(:any)/(:any)', "AbsensiController::export/$1/$2");
$routes->get('/chart', "AbsensiController::chartAbsensi");
$routes->get('/chart/(:any)', "Home::getChartWeek/$1");


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

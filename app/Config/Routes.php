<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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



$routes->group('', ['filter' => 'role:admin,superadmin'], function ($routes) {

	$routes->delete('/children/(:num)', 'ChildrenController::delete/$1');
	$routes->get('/children/edit/(:num)', 'ChildrenController::edit/$1');
	$routes->put('/children/update/(:num)', 'ChildrenController::update/$1');
	$routes->get('/children/add', 'ChildrenController::addChildren');
	$routes->post('/children/insert', 'ChildrenController::insert');
	$routes->get('/children/export', 'ChildrenController::export');
	$routes->get('/children/getChildren', 'ChildrenController::getChildren');
	$routes->get('/children/addClass', 'ChildrenController::addClass');
	$routes->post('/children/class', 'ChildrenController::attemptClass');
	$routes->get('/children/import', 'ChildrenController::addExcel');
	$routes->post('/children/import', 'ChildrenController::import');


	$routes->delete('/pembimbing/(:num)', 'PembimbingController::delete/$1');
	$routes->get('/pembimbing/search', 'PembimbingController::searchPembimbings');
	$routes->get('/pembimbing/add', 'PembimbingController::create');
	$routes->post('/pembimbing/insert', 'PembimbingController::insert');
	$routes->get('/pembimbing/edit/(:num)', 'PembimbingController::edit/$1');
	$routes->put('/pembimbing/update/(:num)', 'PembimbingController::update/$1');
	$routes->get('/pembimbing/export', 'PembimbingController::export');

	$routes->delete('/absensi/(:num)', "AbsensiController::delete/$1");
	$routes->get('/absensi/search', 'AbsensiController::searchData');
	$routes->get('/absensi/add', 'AbsensiController::addAbsensi');
	$routes->get('/absensi/getChildPembimbing/(:num)', 'AbsensiController::getAbsensiByPembimbing/$1');
	$routes->post('/absensi/insert', "AbsensiController::insert");
	$routes->get('/absensi/edit/(:num)', "AbsensiController::edit/$1");
	$routes->put('/absensi/update/(:num)', "AbsensiController::update/$1");

	$routes->get('/history/search/(:any)', "AbsensiController::searchHistory/$1");
	$routes->get('/history/searchall', "AbsensiController::searchAll");
	$routes->get('/export/(:any)/(:any)', "AbsensiController::export/$1/$2");
	$routes->get('/chart', "AbsensiController::chartAbsensi");
	$routes->get('/chart/(:any)', "Home::getChartWeek/$1");
});

$routes->group('', ['filter' => 'role:superadmin,pusat,admin'], function ($routes) {
	$routes->get('/', 'Home::dashboard');

	$routes->get('/children', 'ChildrenController::index');

	$routes->get('/pembimbing', 'PembimbingController::index');

	$routes->get('/absensi', 'AbsensiController::index');

	$routes->get('/history', "AbsensiController::history");


	$routes->get('/settings', 'PusatController::settings');
	$routes->post('/settings/(:any)', 'PusatController::attemptSettings/$1');

	$routes->get('/children/trace', 'TraceController::index');
	$routes->get('/children/trace/getYear/(:num)', 'TraceController::getYear/$1');
	$routes->get('/children/trace/getMonth/(:any)', 'TraceController::getMonth/$1');
	$routes->get('/children/trace/getMonth/(:any)/(:num)', 'TraceController::getMonth/$1/$2');
	$routes->get('/children/trace/details/(:num)/(:any)/(:any)', 'TraceController::details/$1/$2/$3');
	$routes->get('/children/trace/(:any)/(:any)', 'TraceController::trace/$1/$2');
	$routes->get('/children/trace/(:any)/(:any)/(:num)', 'TraceController::trace/$1/$2/$3');

	$routes->get('/trying/(:any)', 'GoogleApiServices::cobagetThumbnailLink/$1');
});

$routes->group('', ['filter' => 'role:pusat'], function ($routes) {
	$routes->get('/pusat/getChartYear/', 'PusatController::getHomeChartYear');
	$routes->get('/pusat/getChartYear/(:any)', 'PusatController::getHomeChartYear/$1');
	$routes->get('/pusat/getChartMonth/(:any)', 'PusatController::getHomeChartMonth/$1');
	$routes->get('/pusat/getChartMonth/(:any)/(:any)', 'PusatController::getHomeChartMonth/$1/$2');
	$routes->get('/pusat/getChildrenCabang/(:any)', 'PusatController::getChildrenByCabang/$1');
	$routes->get('/pusat/getAllChildren', 'PusatController::showAllChildren');

	$routes->get('/children/details/(:num)', 'PusatController::details/$1');

	$routes->get('/pusat/getPembimbing', 'PusatController::getPembimbing');
	$routes->get('/pusat/getPembimbing/(:any)', 'PusatController::getPembimbing/$1');
	$routes->get('/pusat/getSundayDate/(:any)', 'PusatController::getPusatSunday/$1');
	$routes->get('/pusat/getAbsensi', 'PusatController::getAbsensi');
	$routes->get('/pusat/getAbsensi/(:any)', 'PusatController::getAbsensi/$1');
	$routes->get('/pusat/getAbsensi/(:any)/(:any)', 'PusatController::getAbsensi/$1/$2');

	$routes->get('/absensi/details/(:num)', 'PusatController::detailsAbsen/$1');

	$routes->get('/pusat/getHistorys/(:any)', 'PusatController::absensiHistory/$1');
	$routes->get('/pusat/tracking', 'PusatController::trackingData');
	$routes->delete('/pusat/tracking/(:any)', 'PusatController::deleteTracking/$1');
	$routes->get('/pusat/tracking/(:any)', 'PusatController::trackingData/$1');
	$routes->get('/pusat/export/(:any)/(:any)/(:any)', 'PusatController::historyExport/$1/$2/$3');

	$routes->get('/getMonth/(:any)', 'Home::getMonth/$1');
});

$routes->group('', ['filter' => 'role:admin,pusat'], function ($routes) {
	$routes->get('/rank', 'RankingController::index');
	$routes->get('/rank/getYear/(:num)', 'RankingController::gettingYear/$1');
	$routes->get('/rank/getDate/(:any)/(:num)', 'RankingController::getAbsensiDate/$1/$2');
	$routes->get('/rank/getDate/(:any)', 'RankingController::getAbsensiDate/$1');

	$routes->get('/rank/getKelas/(:any)/(:any)/(:num)', 'RankingController::getKelas/$1/$2/$3');
	$routes->get('/rank/getKelas/(:any)/(:any)', 'RankingController::getKelas/$1/$2');

	$routes->get('/rank/getMonth/(:num)/(:any)', 'RankingController::getMonthAbsensi/$1/$2');
	$routes->post('/rank', 'RankingController::getReport');
});

$routes->group('', ['filter' => 'role:superadmin,pusat'], function ($routes) {
	$routes->get('/', 'Home::dashboard');
	$routes->get('/team', "TeamController::index");
	$routes->get('/team/edit/(:num)', "TeamController::edit/$1");

	$routes->put('/team/update/(:num)', "TeamController::attemptEdit/$1");
	$routes->get('/team/cabang', "TeamController::getCabang");
	$routes->put('/team/refresh', "TeamController::refresh");
	$routes->delete('/team/(:num)', 'TeamController::deleteTeam/$1');
});



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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

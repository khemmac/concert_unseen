<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
//$route['controller/(:any)'] = '$1';

//$route['default_controller'] = 'pages/view';
//$route['(:any)'] = 'pages/view/$1';

//$route['404_override'] = '';

// add route for seat_early segment
$route['seat_early/submit'] = 'seat_early/submit';
$route['seat_early/(:num)'] = 'seat_early/index/$1';

// add route for zone_early segment
$route['zone_early/(:num)'] = 'zone_early/index/$1';

// add route for seat presale segment
$route['seat_presale/soldout/(:any)'] = 'seat_presale/soldout/$1';
$route['seat_presale/submit'] = 'seat_presale/submit';
$route['seat_presale/(:any)'] = 'seat_presale/index/$1';

// add route for seat u (ยืน) segment
$route['seat_u/submit'] = 'seat_u/submit';
$route['seat_u/(:any)'] = 'seat_u/index/$1';

// add route for seat segment
$route['seat/fetch'] = 'seat/fetch';
$route['seat/submit'] = 'seat/submit';
$route['seat/add'] = 'seat/add';
$route['seat/remove'] = 'seat/remove';
$route['seat/(:any)'] = 'seat/index/$1';

// add route for zone segment
$route['zone/(:num)'] = 'zone/index/$1';

// add route for booking segment
$route['booking/(:num)'] = 'booking/index/$1';

// landing / home page
$route['sbsmtv2013'] = 'index/sbsmtv2013';
$route['sbs2013'] = 'index/sbs2013';

$route['default_controller'] = "index";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
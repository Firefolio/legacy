<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// Application Routes
$route['project/(:any)'] = 'portfolio/project/$1';

$route['login'] = 'backend/user/index';
$route['login/attempt'] = 'backend/user/login';
$route['logout'] = 'backend/user/logout';

$route['firefolio/projects'] = 'backend/project/index';
$route['firefolio/projects/(:any)'] = 'backend/project/index/$1';
$route['firefolio/projects/create/submit'] = 'backend/project/create_project';
$route['firefolio/projects/update/(:any)'] = 'backend/project/index/update/$1';
$route['firefolio/projects/update/(:any)/submit'] = 'backend/project/update_project';
$route['firefolio/projects/delete'] = 'backend/project/index/delete';
$route['firefolio/projects/search'] = 'backend/project/index/search';

$route['firefolio/profile'] = 'backend/profile/index';
$route['firefolio/profile/update'] = 'backend/profile/update';

$route['firefolio/administration'] = 'backend/administration/index';

// Reserved Routes
$route['default_controller'] = 'portfolio';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

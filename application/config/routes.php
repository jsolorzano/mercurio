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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'CLogin/login/';
$route['logout'] = 'CLogin/logout/';
$route['home'] = 'Home/home/';
$route['admin'] = 'Welcome/admin/';
/* page public*/
$route['public'] = 'welcome';
$route['somos'] = 'welcome/somos';
$route['servicios'] = 'welcome/servicios';
$route['solicitud'] = 'welcome/solicitud';
$route['noticias'] = 'welcome/noticias';
$route['cuenta'] = 'welcome/cuenta';

/* perfiles */
$route['profile'] = 'CPerfil';
$route['profile_register'] = 'CPerfil/register';
$route['profile_edit/(:num)'] = 'CPerfil/edit/$1';
$route['profile_delete/(:num)'] = 'CPerfil/delete/$1';
/*   Users */
$route['users'] = 'CUser';
$route['users_register'] = 'CUser/register';
$route['users_edit/(:num)'] = 'CUser/edit/$1';
/*   Franchises */
$route['franchises'] = 'CFranchises';
$route['franchises/register'] = 'CFranchises/register';
$route['franchises/edit/(:num)'] = 'CFranchises/edit/$1';
$route['franchises/delete/(:num)'] = 'CFranchises/delete/$1';
/*   Services */
$route['services'] = 'CServices';
$route['services/register'] = 'CServices/register';
$route['services/edit/(:num)'] = 'CServices/edit/$1';
$route['services/delete/(:num)'] = 'CServices/delete/$1';
/*   Product */
$route['product'] = 'CProduct';
$route['product/register'] = 'CProduct/register';
$route['product/edit/(:num)'] = 'CProduct/edit/$1';
$route['product/delete/(:num)'] = 'CProduct/delete/$1';
/*   Order */
$route['order'] = 'COrder';
$route['order/register'] = 'COrder/register';
$route['order/edit/(:num)'] = 'COrder/edit/$1';
$route['order/delete/(:num)'] = 'COrder/delete/$1';
/*   clients */
$route['clients'] = 'CClient';
$route['clients/register'] = 'CClient/register';
$route['clients/edit/(:num)'] = 'CClient/edit/$1';
$route['clients/delete/(:num)'] = 'CClient/delete/$1';
$route['clients/ajax_client'] = 'CClient/ajax_client';
/*   Assignment */
$route['assignment'] = 'CAssignment';
$route['assignment/register'] = 'CAssignment/register';
$route['assignment/edit/(:num)'] = 'CAssignment/edit/$1';
$route['assignment/delete/(:num)'] = 'CAssignment/delete/$1';
/*   Menús */
$route['menus'] = 'CMenus';
$route['menus/register'] = 'CMenus/register';
$route['menus/edit/(:num)'] = 'CMenus/edit/$1';
$route['menus/delete/(:num)'] = 'CMenus/delete/$1';
/*   Submenús */
$route['submenus'] = 'CSubMenus';
$route['submenus/register'] = 'CSubMenus/register';
$route['submenus/edit/(:num)'] = 'CSubMenus/edit/$1';
$route['submenus/delete/(:num)'] = 'CSubMenus/delete/$1';
/*   modulos */
$route['modulos'] = 'CModulos';
$route['modulos/register'] = 'CModulos/register';
$route['modulos/edit/(:num)'] = 'CModulos/edit/$1';
$route['modulos/delete/(:num)'] = 'CModulos/delete/$1';
/*assets*/
$route['assets/(:any)'] = 'assets/$1';

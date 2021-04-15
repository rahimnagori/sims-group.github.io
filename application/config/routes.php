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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* Static pages */
$route['Contact'] = 'Home/contact';
$route['Covid-Details'] = 'Home/covid_details';
$route['Electrical-Details'] = 'Home/electrical_details';
$route['Transformer-Details'] = 'Home/transformer_details';
$route['Panel-Details'] = 'Home/panel_details';
$route['Furniture-Details'] = 'Home/furniture_details';
$route['Carpenter-Details'] = 'Home/carpenter_details';
$route['Fire-Details'] = 'Home/fire_details';
$route['About'] = 'Home/about';
$route['Services'] = 'Home/services';


$route['Community'] = 'Home/community';
$route['Sounds/(:any)'] = 'Home/sounds/$1';
$route['Sound-Details/(:any)'] = 'Home/sound_details/$1';
$route['Collections/(:any)'] = 'Home/collections/$1';
$route['Collection-Details/(:any)'] = 'Home/collection_details/$1';
$route['Blogs/(:any)'] = 'Home/blogs/$1';
$route['Blog_Details/(:any)'] = 'Home/blog_details/$1';
$route['Faqs'] = 'Home/faqs';
$route['Terms'] = 'Home/terms';
$route['Payment'] = 'Home/payment';
$route['Tips'] = 'Home/tips';
$route['Works'] = 'Home/works';
$route['Partner'] = 'Home/partner';
$route['Policy'] = 'Home/policy';
$route['Price'] = 'Home/price';
$route['Verify/(:any)/(:any)'] = 'Users/email_verification/$1/$2';
$route['Verify'] = 'Users/email_verified';
$route['Email-Verify'] = 'Profile/verify';
$route['Edit-Profile'] = 'Profile/edit';
$route['Plan'] = 'Plans';
$route['Logout'] = 'Users/logout';

/* Site Page */

/* Admin Pages */
$route['Admin'] = 'Admin';
$route['Admin/Dashboard'] = 'Admin_Dashboard';
$route['Admin/Business'] = 'Admin_Business';
$route['Admin/Services'] = 'Admin_Services';

$route['Admin/Users'] = 'Admin_Users';
$route['Admin/Contacts'] = 'Admin_Contacts';
$route['Admin/profile'] = 'Admin_Dashboard/profile';
$route['Admin/Blogs'] = 'Admin_Blogs';
$route['Admin/Categories'] = 'Admin_Categories';
$route['Admin/Plans'] = 'Admin_Plans';
$route['Admin-Sound'] = 'Admin_Sound';
$route['Admin-Collections'] = 'Admin_Collections';
$route['Admin-Banners'] = 'Admin_Banners';
$route['Admin/Logout'] = 'Admin/logout';
// $route['Test'] = 'Test';
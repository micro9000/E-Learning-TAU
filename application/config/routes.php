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

// Students Routing:
//

$route['student_login'] = "students/login";


// Admin Routing:
//

$route['admin_login_page'] = "admin/login_page";
$route['admin_login'] = "admin/login";
$route['admin_logout'] = "admin/destroy_admin_session";
$route['admin_main_panel'] = "admin/main_panel";

// Principles

$route['admin_agriculture_principles'] = "admin/agriculture_principles";
$route['admin_agriculture_principles/(:any)'] = "admin/agriculture_principles/$1";
$route['add_agri_principle'] = "admin/add_principle";
$route['get_all_principles'] = "admin/get_all_principles";
$route['search_principles'] = "admin/search_principles";
$route['delete_principle'] = "admin/delete_principle";
$route['update_principle'] = "admin/update_principle";

// Sub topics

$route['admin_principles_sub_topics'] = "admin/principles_sub_topics";
$route['admin_principles_sub_topics/(:any)'] = "admin/principles_sub_topics/$1";
$route['add_principle_sub_topic'] = "admin/add_principle_sub_topic";
$route['get_all_principles_sub_topic'] = "admin/get_all_principles_sub_topics";
$route['search_principles_sub_topics'] = "admin/search_principles_sub_topics";
$route['delete_principle_sub_topic'] = "admin/delete_principle_sub_topic";
$route['update_principle_sub_topic'] = "admin/update_principle_sub_topic";


// Chapters

$route['sub_topic_chapters'] = "admin/sub_topic_chapters";
$route['sub_topic_chapters/(:any)'] = "admin/sub_topic_chapters/$1";
$route['get_principles_sub_topics_by_principle'] = "admin/get_principles_sub_topics_by_principle";
$route['add_topic_new_chapter'] = "admin/add_topic_new_chapter";
$route['update_topic_chapter'] = "admin/update_topic_chapter";
$route['delete_topic_chapter'] = "admin/delete_topic_chapter";
$route['get_all_chapters'] = "admin/get_all_topics_chapters";
$route['get_chapter_by_id'] = "admin/get_chapter_by_id";
$route['search_topics_chapters'] = "admin/search_topics_chapters";


// Lessons

$route['chapters_lessons'] = "admin/chapters_lessons";


// Faculties

$route['faculties'] = "admin/faculty_list";

$route['home_page'] = "students/home";

$route['default_controller'] = 'students';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
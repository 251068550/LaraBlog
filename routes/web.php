<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


/*系统相关路由*/
Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth']],function ($router)
{
    $router->get('/dash','DashboardController@index')->name('system.index');
    $router->get('/i18n', 'DashboardController@dataTableI18n');

    /***************** 系统相关 *****************/
    // 权限
    require(__DIR__ . '/admin/system/permission.php');
    // 角色
    require(__DIR__ . '/admin/system/role.php');
    // 用户
    require(__DIR__ . '/admin/system/user.php');
    // 菜单
    require(__DIR__ . '/admin/system/menu.php');

    /***************** 博客相关 *****************/
    // 博客分类
    require(__DIR__ . '/admin/blog/category.php');
    // 标签
    require(__DIR__ . '/admin/blog/tag.php');
    // 文章
    require(__DIR__ . '/admin/blog/article.php');
});

// 后台系统日志
Route::group(['prefix' => 'admin/log','middleware' => ['auth','check.permission:log']],function ($router)
{
    $router->get('/','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index')->name('log.dash');
    $router->get('list','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs')->name('log.index');
    $router->post('delete','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete')->name('log.destroy');
    $router->get('/{date}','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show')->name('log.show');
    $router->get('/{date}/download','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download')->name('log.download');
    $router->get('/{date}/{level}','\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel')->name('log.filter');
});
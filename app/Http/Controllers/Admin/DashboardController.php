<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:system');
    }

    /**
     * 控制台
     * @author nicmic
     * @date   2017-03-05
     */
    public function index()
    {
        return view('admin.system.dashboard.index');
    }

    /**
     * datatable国际化
     * @author nicmic
     * @date   2017-03-05
     */
    public function dataTableI18n()
    {
        return response()->json(trans('pagination.i18n'));
    }
}

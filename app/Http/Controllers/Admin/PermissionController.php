<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Service\Admin\PermissionService;

class PermissionController extends Controller
{
    private $permission;

    function __construct(PermissionService $permission)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:permission');
        $this->permission = $permission;
    }
    /**
     * 权限列表
     * @author nicmic
     * @date   2017-03-05
     */
    public function index()
    {
        return view('admin.system.permission.list');
    }
    /**
     * datatables获取数据
     * @author nicmic
     * @date   2017-03-05
     */
    public function ajaxIndex()
    {
        $responseData = $this->permission->ajaxIndex();
        return response()->json($responseData);
    }

    /**
     * 添加权限视图
     * @author nicmic
     * @date   2017-03-05
     */
    public function create()
    {
        return view('admin.system.permission.create');
    }

    /**
     * 添加权限
     * @author nicmic
     * @date   2017-03-05
     */
    public function store(PermissionRequest $request)
    {
        $this->permission->storePermission($request->all());
        return redirect('admin/permission');
    }

    /**
     * 修改权限视图
     * @author nicmic
     * @date   2017-03-05
     */
    public function edit($id)
    {
        $permission = $this->permission->editView($id);
        return view('admin.system.permission.edit')->with(compact('permission'));
    }

    /**
     * 修改权限
     * @author nicmic
     * @date   2017-03-05
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->permission->updatePermission($request->all(),$id);
        return redirect('admin/permission');
    }

    /**
     * 删除权限
     * @author nicmic
     * @date   2017-03-05
     */
    public function destroy($id)
    {
        $this->permission->destroyPermission($id);
        return redirect('admin/permission');
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Service\Admin\RoleService;

class RoleController extends Controller
{
    private $role;

    function __construct(RoleService $role)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:role');
        $this->role = $role;
    }

    /**
     * 角色列表
     * @author nicmic
     * @date   2017-03-05
     */
    public function index()
    {
        return view('admin.system.role.list');
    }
    /**
     * datatables获取数据
     * @author nicmic
     * @date   2017-03-05
     */
    public function ajaxIndex()
    {
        $responseData = $this->role->ajaxIndex();
        return response()->json($responseData);
    }

    /**
     * 创建角色视图
     * @author nicmic
     * @date   2017-03-05
     */
    public function create()
    {
        $permissions = $this->role->getAllPermissionList();
        return view('admin.system.role.create')->with(compact('permissions'));
    }

    /**
     * 添加角色
     * @author nicmic
     * @date   2017-03-05
     */
    public function store(RoleRequest $request)
    {
        $this->role->storeRole($request->all());
        return redirect('admin/role');
    }

    /**
     * 查看角色
     * @author nicmic
     * @date   2017-03-05
     */
    public function show($id)
    {
        $role = $this->role->findRoleById($id);
        return view('admin.system.role.show')->with(compact('role'));
    }

    /**
     * 修改角色
     * @author nicmic
     * @date   2017-03-05
     */
    public function edit($id)
    {
        $permissions = $this->role->getAllPermissionList();
        $role = $this->role->findRoleById($id);
        return view('admin.system.role.edit')->with(compact('role','permissions'));
    }

    /**
     * 修改角色
     * @author nicmic
     * @date   2017-03-05
     */
    public function update(RoleRequest $request, $id)
    {
        $this->role->updateRole($request->all(),$id);
        return redirect('admin/role');
    }

    /**
     * 删除角色
     * @author nicmic
     * @date   2017-03-05
     */
    public function destroy($id)
    {
        $this->role->destroyRole($id);
        return redirect('admin/role');
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Service\Admin\UserService;

class UserController extends Controller
{
    private $user;

    function __construct(UserService $user)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:user');
        $this->user = $user;
    }

    /**
     * 用户列表
     * @author nicmic
     * @date   2017-03-05
     */
    public function index()
    {
        return view('admin.system.user.list');
    }

    public function ajaxIndex()
    {
        $responseData = $this->user->ajaxIndex();
        return response()->json($responseData);
    }

    /**
     * 创建用户视图
     * @author nicmic
     * @date   2017-03-05
     */
    public function create()
    {
        list($permissions,$roles) = $this->user->createView();
        return view('admin.system.user.create')->with(compact('permissions','roles'));
    }

    /**
     * 添加用户
     * @author nicmic
     * @date   2017-03-05
     */
    public function store(UserRequest $request)
    {
        $this->user->storeUser($request->all());
        return redirect('admin/user');
    }

    /**
     * 查看用户信息
     * @author nicmic
     * @date   2017-03-05
     */
    public function show($id)
    {
        $user = $this->user->findUserById($id);
        return view('admin.system.user.show')->with(compact('user'));
    }

    /**
     * 修改用户视图
     * @author nicmic
     * @date   2017-03-05
     */
    public function edit($id)
    {
        list($user,$permissions,$roles) = $this->user->editView($id);
        return view('admin.system.user.edit')->with(compact('user','permissions','roles'));
    }

    /**
     * 修改用户
     * @author nicmic
     * @date   2017-03-05
     */
    public function update(UserRequest $request, $id)
    {
        $this->user->updateUser($request->all(),$id);
        return redirect('admin/user');
    }

    /**
     * 删除用户
     * @author nicmic
     * @date   2017-03-05
     */
    public function destroy($id)
    {
        $this->user->destroyUser($id);
        return redirect('admin/user');
    }

    /**
     * 重置用户密码
     * @author nicmic
     * @date   2017-03-05
     */
    public function resetPassword($id)
    {
        $responseData = $this->user->resetUserPassword($id);
        return response()->json($responseData);
    }
}

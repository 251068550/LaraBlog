<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Service\Admin\MenuService;

class MenuController extends Controller
{
    private $menu;

    public function __construct(MenuService $menu)
    {
        // 自定义权限中间件
        $this->middleware('check.permission:menu');
        $this->menu = $menu;
    }

    /**
     * 菜单列表
     * @author nicmic
     * @date   2017-03-05
     * @return [type]     [description]
     */
    public function index()
    {
        $menus = $this->menu->getMenuList();
        return view('admin.system.menu.list')->with(compact('menus'));
    }

    /**
     * 添加菜单视图
     * @author nicmic
     * @date   2017-03-05
     * @return [type]     [description]
     */
    public function create()
    {
        $menus = $this->menu->getMenuList();
        return view('admin.system.menu.create')->with(compact('menus'));
    }

    /**
     * 添加菜单
     * @author nicmic
     * @date   2017-03-05
     */
    public function store(MenuRequest $request)
    {
        $responseData = $this->menu->storeMenu($request->all());
        return response()->json($responseData);
    }

    /**
     * 查看菜单详细数据
     * @author nicmic
     * @date   2017-03-05
     */
    public function show($id)
    {
        $menus = $this->menu->getMenuList();
        $menu = $this->menu->findMenuById($id);
        return view('admin.system.menu.show')->with(compact('menu','menus'));
    }

    /**
     * 修改菜单视图
     * @author nicmic
     * @date   2017-03-05
     */
    public function edit($id)
    {
        $menu = $this->menu->findMenuById($id);
        $menus = $this->menu->getMenuList();
        return view('admin.system.menu.edit')->with(compact('menu','menus'));
    }

    /**
     * 修改菜单数据
     * @author nicmic
     * @date   2017-03-05
     */
    public function update(MenuRequest $request, $id)
    {
        $responseData = $this->menu->updateMenu($request->all(),$id);
        return response()->json($responseData);
    }

    /**
     * 删除菜单
     * @author nicmic
     * @date   2017-03-05
     */
    public function destroy($id)
    {
        $this->menu->destroyMenu($id);
        return redirect('admin/menu');
    }

    public function orderable()
    {
        $responseData = $this->menu->orderable(request('nestable',''));
        return response()->json($responseData);
    }
}

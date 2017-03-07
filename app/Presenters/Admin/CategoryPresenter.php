<?php
namespace App\Presenters\Admin;

class CategoryPresenter
{
	public function categoryNestable($categories)
	{
		if ($categories) {
			$item = '';
			foreach ($categories as $v) {
				$item.= $this->getNestableItem($v);
			}
			return $item;
		}
		return '暂无菜单';
	}

	/**
	 * 返回菜单HTML代码
	 * @author 晚黎
	 * @date   2016-12-08T16:28:15+0800
	 * @param  [type]                   $menu [description]
	 * @return [type]                         [description]
	 */
	protected function getNestableItem($menu)
	{
		if ($menu['child']) {
			return $this->getHandleList($menu['id'],$menu['name'],$menu['icon'],$menu['child']);
		}
		$labelInfo = $menu['pid'] == 0 ?  'label-info':'label-warning';
		$icon = empty($menu['icon']) ? '':'<i class="'.$menu['icon'].'"></i>';
		return <<<Eof
				<li class="dd-item dd3-item" data-id="{$menu['id']}">
                    <div class="dd-handle dd3-handle">Drag</div>
                    <div class="dd3-content"><span class="label {$labelInfo}">{$icon}</span> {$menu['name']} {$this->getActionButtons($menu['id'])}</div>
                </li>
Eof;
	}
	/**
	 * 判断是否有子集
	 * @author 晚黎
	 * @date   2016-11-04T11:05:28+0800
	 * @param  [type]                   $id    [description]
	 * @param  [type]                   $name  [description]
	 * @param  [type]                   $child [description]
	 * @return [type]                          [description]
	 */
	protected function getHandleList($id,$name,$icon,$child)
	{
		$handle = '';
		if ($child) {
			foreach ($child as $v) {
				$handle .= $this->getNestableItem($v);
			}
		}
		$icon = empty($icon) ? '':'<i class="'.$icon.'"></i>';
		$html = <<<Eof
		<li class="dd-item dd3-item" data-id="{$id}">
            <div class="dd-handle dd3-handle">Drag</div>
            <div class="dd3-content">
            	<span class="label label-info">{$icon}</span> {$name} {$this->getActionButtons($id)}
            </div>
            <ol class="dd-list">
                {$handle}
            </ol>
        </li>
Eof;
		return $html;
	}

	/**
	 * 菜单按钮
	 * @author 晚黎
	 * @date   2016-11-04T11:05:38+0800
	 * @param  [type]                   $id   [description]
	 * @param  boolean                  $bool [description]
	 * @return [type]                         [description]
	 */
	protected function getActionButtons($id)
	{
		$action = '<div class="pull-right">';
		if (auth()->user()->can(config('admin.permissions.category.show'))) {
			$action .= '<a href="javascript:;" class="btn btn-xs tooltips showInfo" data-href="'.url('admin/category',[$id]).'" data-toggle="tooltip" data-original-title="'.trans('admin/action.actionButton.show').'"  data-placement="top"><i class="fa fa-eye"></i></a>';
		}
		if (auth()->user()->can(config('admin.permissions.category.edit'))) {
			$action .= '<a href="javascript:;" data-href="'.url('admin/category/'.$id.'/edit').'" class="btn btn-xs tooltips editMenu" data-toggle="tooltip"data-original-title="'.trans('admin/action.actionButton.edit').'"  data-placement="top"><i class="fa fa-edit"></i></a>';
		}
		if (auth()->user()->can(config('admin.permissions.category.destroy'))) {
			$action .= '<a href="javascript:;" class="btn btn-xs tooltips destroy_item" data-id="'.$id.'" data-original-title="'.trans('admin/action.actionButton.destroy').'"data-toggle="tooltip"  data-placement="top"><i class="fa fa-trash"></i><form action="'.url('admin/category',[$id]).'" method="POST" style="display:none"><input type="hidden"name="_method" value="delete"><input type="hidden" name="_token" value="'.csrf_token().'"></form></a>';
		}
		$action .= '</div>';
		return $action;
	}
	/**
	 * 根据用户不同的权限显示不同的内容
	 * @author 晚黎
	 * @date   2016-11-04T13:40:11+0800
	 * @return [type]                   [description]
	 */
	public function canCreateCategory()
	{
		$canCreateMenu = auth()->user()->can(config('admin.permissions.category.create'));

		$title = $canCreateMenu ?  trans('admin/category.welcome'):trans('admin/category.sorry');
		$desc = $canCreateMenu ? trans('admin/category.description'):trans('admin/category.description_sorry');
		$createButton = $canCreateMenu ? '<br><a href="javascript:;" class="btn btn-primary m-t create_menu">'.trans('admin/category.action.create').'</a>':'';
		return <<<Eof
		<div class="middle-box text-center animated fadeInRightBig">
            <h3 class="font-bold">{$title}</h3>
            <div class="error-desc">
                {$desc}{$createButton}
            </div>
        </div>
Eof;
	}
	/**
	 * 添加修改菜单关系select
	 * @author 晚黎
	 * @date   2016-11-04T16:29:51+0800
	 * @param  [type]                   $menus [description]
	 * @param  string                   $pid   [description]
	 * @return [type]                          [description]
	 */
	public function topMenuList($menus,$pid = '')
	{
		$html = '<option value="0">'.trans('admin/category.topMenu').'</option>';
		if ($menus) {
			foreach ($menus as $v) {
				$html .= '<option value="'.$v['id'].'" '.$this->checkMenu($v['id'],$pid).'>'.$v['name'].'</option>';
			}
		}
		return $html;
	}

	public function checkMenu($menuId,$pid)
	{
		if ($pid !== '') {
			if ($menuId == $pid) {
				return 'selected="selected"';
			}
			return '';
		}
		return '';
	}
	/**
	 * 获取菜单关系名称
	 * @author 晚黎
	 * @date   2016-11-04
	 * @param  [type]     $menus [所有菜单数据]
	 * @param  [type]     $pid   [菜单关系pid]
	 * @return [type]            [description]
	 */
	public function topMenuName($menus,$pid)
	{
		if ($pid == 0) {
			return '顶级菜单';
		}
		if ($menus) {
			foreach ($menus as $v) {
				if ($v['id'] == $pid) {
					return $v['name'];
				}
			}
		}
		return '';
	}
}
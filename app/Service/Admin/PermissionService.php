<?php
namespace App\Service\Admin;
use App\Repositories\Eloquent\PermissionRepositoryEloquent;
use App\Traits\SendSystemErrorTrait;
use Exception;

/**
* 权限service
*/
class PermissionService
{
	use SendSystemErrorTrait;
	protected $permission;

	function __construct(PermissionRepositoryEloquent $permission)
	{
		$this->permission =  $permission;
	}
	/**
	 * datatables获取数据
     * @author nicmic
     * @date   2017-03-05
	 * @return [type]                   [description]
	 */
	public function ajaxIndex()
	{
		// datatables请求次数
		$draw = request('draw', 1);
		// 开始条数
		$start = request('start', config('admin.golbal.list.start'));
		// 每页显示数目
		$length = request('length', config('admin.golbal.list.length'));
		// datatables是否启用模糊搜索
		$search['regex'] = request('search.regex', false);
		// 搜索框中的值
		$search['value'] = request('search.value', '');
		// 排序
		$order['name'] = request('columns.' .request('order.0.column',0) . '.name');
		$order['dir'] = request('order.0.dir','asc');

		$result = $this->permission->getPermissionList($start,$length,$search,$order);

		$permissions = [];

		if ($result['permissions']) {
			foreach ($result['permissions'] as $v) {
				$v->actionButton = $v->getActionButtonAttribute();
				$permissions[] = $v;
			}
		}

		return [
			'draw' => $draw,
			'recordsTotal' => $result['count'],
			'recordsFiltered' => $result['count'],
			'data' => $permissions,
		];
	}
	/**
	 * 添加权限
     * @author nicmic
     * @date   2017-03-05
	 * @param  [type]                   $formData [表单中所有的数据]
	 * @return [type]                             [true or false]
	 */
	public function storePermission($formData)
	{
		try {
			$result = $this->permission->create($formData);
			flash_info($result,trans('admin/alert.permission.create_success'),trans('admin/alert.permission.create_error'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
	}
	/**
	 * 根据ID获取权限数据
     * @author nicmic
     * @date   2017-03-05
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [查询出来的权限对象，查不到数据时跳转404]
	 */
	public function editView($id)
	{
		$permission =  $this->permission->find($id);
		if ($permission) {
			return $permission;
		}
		abort(404);
	}
	/**
	 * 修改权限
     * @author nicmic
     * @date   2017-03-05
	 * @param  [type]                   $attributes [表单数据]
	 * @param  [type]                   $id         [resource路由传递过来的id]
	 * @return [type]                               [true or false]
	 */
	public function updatePermission($attributes,$id)
	{
		// 防止用户恶意修改表单id，如果id不一致直接跳转500
		if ($attributes['id'] != $id) {
			abort(500);
		}
		try {
			$result = $this->permission->update($attributes,$id);
			flash_info($result,trans('admin/alert.permission.edit_success'),trans('admin/alert.permission.edit_error'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
	}
	/**
	 * 权限暂不做状态管理，直接删除
     * @author nicmic
     * @date   2017-03-05
	 * @param  [type]                   $id [权限id]
	 * @return [type]                       [true or false]
	 */
	public function destroyPermission($id)
	{
		try {
			$result = $this->permission->delete($id);
			flash_info($result,trans('admin/alert.permission.destroy_success'),trans('admin/alert.permission.destroy_error'));
			return $result;
		} catch (Exception $e) {
			// 错误信息发送邮件
			$this->sendSystemErrorMail(env('MAIL_SYSTEMERROR',''),$e);
			return false;
		}
		
	}
}
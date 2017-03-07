<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['name'] = 'required';
        // 添加权限
        if (request()->isMethod('POST')) {
            $rules['slug'] = 'required|unique:permissions,slug';
        }else{
            // 修改时 request()->method() 方法返回的是 PUT或PATCH
            $rules['slug'] = 'required|unique:permissions,slug,'.$this->id;
            $rules['id'] = 'numeric|required';
        }
        return $rules;
    }
    /**
     * 验证信息
     * @author nicmic
     * @date   2017-03-05
     */
    public function messages()
    {
        return [
            'required'  => trans('validation.required'),
            'unique'    => trans('validation.unique'),
            'numeric'   => trans('validation.numeric'),
        ];
    }
    /**
     * 字段名称
     * @author nicmic
     * @date   2017-03-05
     */
    public function attributes()
    {
        return [
            'id'    => trans('admin/permission.model.id'),
            'name'  => trans('admin/permission.model.name'),
            'slug'  => trans('admin/permission.model.slug'),
        ];
    }
}

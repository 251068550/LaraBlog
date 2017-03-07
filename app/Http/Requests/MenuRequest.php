<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class MenuRequest extends FormRequest
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
        $rules['slug'] = 'required';
        $rules['url'] = 'required';
        // 添加权限
        if (request()->isMethod('PUT') || request()->isMethod('PATH')) {
            // 修改时 request()->method() 方法返回的是 PUT或PATCH
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
            'name'      => trans('admin/menu.model.name'),
            'url'       => trans('admin/menu.model.url'),
            'slug'      => trans('admin/menu.model.slug'),
            'id'        => trans('admin/menu.model.id'),
        ];
    }
}

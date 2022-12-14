<?php

namespace Lvg\LvgMenus\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Lvg\LvgMenus\Models\Menu;
class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => ["sometimes", "string"],
            "icon" => ["nullable", "string"],
            "route" => ["nullable", "string"],
            "url" => ["nullable", "string"],
            "active_pattern" => ["nullable", "string"],
            "position" => ["nullable", "integer"],
            "permission_name" => ["nullable", "string"],
            "module_name" => ["nullable", "string"],
            "description" => ["nullable", "string"],
            "parent" => ["nullable", "array"],
            "active" =>["sometimes","boolean"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("update", $this->menu);
    }

    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();
        //Add your code for manipulation with request data here
        return $sanitized;
    }
    /**
     * Return modified (sanitized data) as a php object
     * @return  object
     */
    public function sanitizedObject(): object
    {
        return json_decode(collect($this->sanitizedArray()));
    }
}

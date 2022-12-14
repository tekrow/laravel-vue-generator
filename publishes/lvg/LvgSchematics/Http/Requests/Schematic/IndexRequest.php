<?php

namespace Lvg\LvgSchematics\Http\Requests\Schematic;

use Illuminate\Foundation\Http\FormRequest;
use Lvg\LvgSchematics\Models\Schematic;
class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "table_name" => [],
            "model_class" => [],
            "controller_class" => [],
            "route_name" => [],
            "generated_at" => [],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("viewAny", Schematic::class);
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

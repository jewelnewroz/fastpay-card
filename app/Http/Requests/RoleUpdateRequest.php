<?php
namespace App\Http\Requests;

use App\Traits\FormRequestResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    use FormRequestResponseTrait;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
//        dd($this->session->getId());
        return [
            'name' => 'bail|required|unique:roles,name,' . $this->role,
            'permission' => 'bail|required|array'
        ];
    }
}

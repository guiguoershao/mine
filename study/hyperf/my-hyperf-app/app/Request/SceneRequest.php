<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class SceneRequest extends FormRequest
{
    protected $scenes = [
        'foo' => ['username'],
        'bar' => ['username', 'password'],
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'gender' => 'required',
        ];
    }
}
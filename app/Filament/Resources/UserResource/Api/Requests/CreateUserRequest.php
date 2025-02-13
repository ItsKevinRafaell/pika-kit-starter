<?php

namespace App\Filament\Resources\UserResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'email' => 'required|string',
			'email_verified_at' => 'required',
			'password' => 'required|string',
			'remember_token' => 'required|string',
			'avatar_url' => 'required|string',
			'theme' => 'required|string',
			'theme_color' => 'required|string'
		];
    }
}

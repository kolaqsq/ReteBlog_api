<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $username
 */
class CheckUsernameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['string', 'max:255', 'unique:users,username', 'regex:/^[\w-]+$/'],
        ];
    }
}

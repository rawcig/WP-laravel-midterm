<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrganizerRequest extends FormRequest
{
    //  determine if the user is authorized to make this request.
    
    public function authorize(): bool
    {
        return true;
    }

    //  Get the validation rules that apply to the request.
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizers,email',
            'phone' => 'required|string|max:20|unique:organizers,phone',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ];
    }

    // Get custom messages for validator errors.
    
    public function messages(): array
    {
        return [
            'name.required' => 'The organizer name is required.',
            'name.max' => 'The organizer name may not be greater than 255 characters.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'The phone number is required.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'phone.unique' => 'This phone number is already registered.',
            'description.string' => 'The description must be a valid text.',
            'website.url' => 'Please enter a valid website URL.',
            'website.max' => 'The website URL may not be greater than 255 characters.',
        ];
    }
}

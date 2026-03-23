<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrganizerRequest extends FormRequest
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
        $organizerId = $this->route('organizer');
        
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('organizers', 'email')->ignore($organizerId)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('organizers', 'phone')->ignore($organizerId)],
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
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

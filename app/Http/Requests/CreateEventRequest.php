<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:today',
            'location' => 'nullable|string|max:255',
        ];
    }

   
    public function messages(): array
    {
        return [
            'title.required' => 'The event title is required.',
            'title.max' => 'The event title may not be greater than 255 characters.',
            'description.required' => 'The event description is required.',
            'date.required' => 'The event date is required.',
            'date.after' => 'The event date must be a future date.',
            'location.max' => 'The location may not be greater than 255 characters.',
        ];
    }
}

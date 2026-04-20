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
            'max_attendees' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,cancelled,completed',
            'cover_image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'detail_image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:5120',
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
            'max_attendees.integer' => 'Max attendees must be a valid number.',
            'max_attendees.min' => 'Max attendees must be at least 1.',
            'status.required' => 'The event status is required.',
            'status.in' => 'Please select a valid status.',
            'cover_image.mimes' => 'The cover image must be a file of type: jpeg, png, jpg, gif, webp.',
            'cover_image.max' => 'The cover image may not be greater than 2MB.',
            'detail_image.mimes' => 'The detail image must be a file of type: jpeg, png, jpg, gif, webp.',
            'detail_image.max' => 'The detail image may not be greater than 5MB.',
        ];
    }
}

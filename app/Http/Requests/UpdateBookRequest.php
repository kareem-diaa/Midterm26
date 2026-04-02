<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'librarian']);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            // Security Constraint: Ignore the current book's ID to prevent unique constraint failures on update
            'isbn' => ['required', 'string', 'max:255', Rule::unique('books')->ignore($this->route('book'))],
            'copies' => ['required', 'integer', 'min:0'],
        ];
    }
}

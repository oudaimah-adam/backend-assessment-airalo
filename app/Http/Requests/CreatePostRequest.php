<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    use FormRequestTrait;

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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $validDateTimeFormats = implode(',', $this->validDateTimeFormats());

        return [
            'title' => ['required', 'min:3'],
            'body' => ['required', 'min:20'],
            'published_at' => ['sometimes', "date_format:{$validDateTimeFormats}"],
        ];
    }
}

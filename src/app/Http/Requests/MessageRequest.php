<?php

namespace App\Http\Requests;

use App\Helpers\Text;
use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receiver_id' => 'required|numeric',
            'message' => 'required|string'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'message' => $this->input('message')
                ? Text::purify($this->input('message'))
                : null,
        ]);
    }
}

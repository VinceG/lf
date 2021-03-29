<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'uuid', Rule::unique('posts')->ignore($this->id)],
            'title' => ['required'],
            'body' => ['required'],
            'owner_id' => ['numeric', Rule::exists('users', 'id')],
            'main_image' => ['numeric', Rule::exists('files', 'id')],
            'tags' => ['array']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if($this->has('main_image.id')) {
            $this->merge(['main_image' => $this->input('main_image.id')]);
        }

        if($this->has('owner.id')) {
            $this->merge(['owner_id' => $this->input('owner.id')]);
        }
    }
}

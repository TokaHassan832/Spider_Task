<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TweetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tweet' => 'required|string|max:140'
        ];
    }

    public function messages(): array
    {
        return [
            'tweet.required' => __('validation.required_tweet'),
            'tweet.max' => __('validation.max_tweet'),
        ];
    }
}

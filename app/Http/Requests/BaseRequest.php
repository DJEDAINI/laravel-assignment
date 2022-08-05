<?php

namespace App\Http\Requests;

use App\Locales\Language;
use App\Exceptions\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get a proper rules based on the request type.
     *
     * @return array
     */
    public function getAproperRules()
    {
        if ($this->isUpdateRequest()) {
            return $this->updateRules();
        } elseif ($this->isCreateRequest()) {
            return $this->createRules();
        }
    }

    /**
     * Return the rules of update request.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Return the rules of create request.
     *
     * @return array
     */
    public function createRules()
    {
        return [];
    }

    /**
     * Determine if the current request is put or patch.
     *
     * @return bool
     */
    public function isUpdateRequest()
    {
        return $this->isMethod('put') || $this->isMethod('patch');
    }

    /**
     * Determine if the current request is post.
     *
     * @return bool
     */
    public function isCreateRequest()
    {
        return $this->isMethod('post');
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use League\CommonMark\CommonMarkConverter;

class ItemRequest extends BaseRequest
{

    /**
     * Get a the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->getAproperRules();
    }

    /**
     * Get the update validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
             'url' => 'required|url',
            'description' => 'required|string',
        ];
    }

    /**
     * Get the creation validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
             'url' => 'required|url',
            'description' => 'required|string',
        ];
    }

    /**
     * The attributes that will be stored.
     *
     * @return array
     */
    public function data()
    {
        $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

        return [
            'name' => $this->name,
            'price' => $this->price,
            'url' => $this->url,
            'description' => $converter->convert($this->description)->getContent(),
        ];
    }
}
<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->is_free === null) {
            $this->merge(['is_free' => 0]);
        }
    }

    public function rules(): array
    {
        $planId = $this->route('plan');

        $rules  = [
            'name'           => 'required',
            'description'    => 'nullable',
            'price'          => 'required|numeric',
            'billing_period' => 'required',
            'profile_limit'  => 'required|numeric',
            'post_limit'     => 'required|numeric',
            'team_limit'     => 'required|numeric',
            'is_free'        => 'nullable|boolean',
        ];

        if (setting('is_stripe_activated') && setting('stripe_secret') && setting('stripe_key')) {
            $rules['stripe'] = 'required';
        } else {
            $rules['stripe'] = 'nullable';
        }
        if (setting('paypal_client_id') && setting('paypal_client_secret') && setting('is_paypal_activated')) {
            $rules['paypal'] = 'required';
        } else {
            $rules['paypal'] = 'nullable';
        }
        if (setting('paddle_api_key') && setting('is_paddle_activated')) {
            $rules['paddle'] = 'required';
        } else {
            $rules['paddle'] = 'nullable';
        }
        if (setting('razor_pay_key') && setting('razor_pay_secret') && setting('is_razor_pay_activated')) {
            $rules['razor_pay'] = 'required';
        } else {
            $rules['razor_pay'] = 'nullable';
        }

        return $rules;
    }
}

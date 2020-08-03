<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Customer;

class checkCustomerEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $customer = Customer::where('email', $value)->first();

        return isset($customer->id);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Customer does not exists.';
    }
}

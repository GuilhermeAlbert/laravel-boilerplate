<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckFile implements Rule
{
    public $file;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
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
        if (is_file($this->file)) {
            if ($this->file->isValid()) return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("api.this_file_is_not_valid");
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WordCount implements Rule
{
    protected $maxWords;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxWords)
    {
        $this->maxWords = $maxWords;
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
        return str_word_count($value) <= $this->maxWords;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute may not have more than ' . $this->maxWords . ' words.';
        // return 'The: attribute is less than ' . $this->maxWords . ' words.';
    }
}

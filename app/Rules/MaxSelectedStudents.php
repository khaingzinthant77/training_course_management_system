<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxSelectedStudents implements Rule
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
    public function passes($attribute, $students)
    {
        //
        $maxStudents = request()->input('max_students');
        $selectedStudentsCount = count($students);
        return $selectedStudentsCount <= $maxStudents;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The number of selected students cannot exceed the maximum allowed number of students.';
    }
}
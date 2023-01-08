<?php

namespace AdamovichIvan\CsvDataValidation\Rules;

use App\Services\CsvServices;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Arr;

class CsvContent implements Rule
{


    /**
     * @var string
     */
    protected $rules;
    protected $attribute;
    protected $errors;

    /**
     * Create a new rule instance.
     *
     * @param string $rules
     * @return void
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
        $this->errors = new MessageBag;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value <- csv_file
     * @return bool
     */
    public function passes($attribute, $value): bool
    {


        $rows = CsvServices::getCsvAsArray($value->path());
        $headers = CsvServices::getCsvHeaders($value->path());

        $errors = array();
        foreach ($rows as $rowIndex => $row) {
            $validator = Validator::make(
                $row,
                $this->rules,
            );

            if ($validator->fails()) {
                $errorMessages = $validator->errors()->all();
                $errors[$rowIndex] = array_map(function ($message) use ($rowIndex) {
                    return "Row number $rowIndex: $message";
                }, $errorMessages);
            }
        }

        if (!empty($errors)) {
            $this->errors = $errors;
            return false;
        }

        return true;
    }


    public function message()
    {
        return Arr::flatten($this->errors);
    }
}

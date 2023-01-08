
![СSV Data validator for Laravel](https://banners.beyondco.de/%D0%A1SV%20Data%20validator%20for%20Laravel.png?theme=dark&packageManager=composer+require&packageName=adamovich-ivan%2Fcsv-data-validation&pattern=circuitBoard&style=style_1&description=Easy+way+to+validate+CSV+file+data+in+Requests&md=1&showWatermark=0&fontSize=100px&images=filter)



## Introduction

This class is a custom validator for Laravel, which allows you to validate the contents of a CSV file using the validation rules built into Laravel.
## Functional

- Allows you to check each row and each column of the file for compliance with the specified rules.
- Allows you to use the validation rules built into Laravel.
- Allows you to use custom validation rules.
- Shows exactly which line the error occurred on (Useful for large amounts of data)

This class can be useful if you want to import data from a CSV file into your database, and want to ensure that this data complies with the required rules.

## Installation

You can install the package via composer:

```bash
composer require adamovich-ivan/csv-data-validation
```

## Usage


``` php
use AdamovichIvan/CsvDataValidation/CsvContent;

new CsvContent([
   'firstColumn'  => ['required', 'unique:rainfalls,date', 'date_format:Y-m-d'],
   'secondColumn' => ['required', 'numeric', 'max:255'],
   'thirdСolumn'  => ['required', 'string']
]),
```

### Example


``` php
use Illuminate\Foundation\Http\FormRequest;
use AdamovichIvan/CsvDataValidation/CsvContent;

class ExampleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'сsv_file' => [
                'required',
                'mimes:csv,txt',
                'max:1024',
                new CsvContent([
                    'firstColumn'  => ['required', 'unique:meetings,date', 'date_format:Y-m-d'],
                    'secondColumn' => ['required', 'numeric', 'max:255'],
                    'thirdСolumn'  => ['required', 'string']
                ]),
            ],
        ];
    }
}
```

In this example, the CsvContent class is used in validation rules to check the contents of each column of the CSV file. It takes an array in which each column corresponds to a set of validation rules that should be applied to this column.

For example, for the `firstColumn` column, it is required that the value be mandatory, unique in the `meetings` table and have the date format `Y-m-d`.


After validation, if any of the column values does not match the specified rules, an error validation will be thrown.



## License

The MIT License (MIT). Please see [MIT license](https://opensource.org/licenses/MIT) for more information

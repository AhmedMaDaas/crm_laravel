<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StringOrImage implements Rule
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
        $fileArray = ['image' => $value];
        $rules = ['image' => 'image'];
        return (is_string($value) && $this->checkFileExists($value)) || (($value instanceof UploadedFile) && !(Validator::make($fileArray, $rules)->fails()));
    }

    private function checkFileExists($path){
        if(str_starts_with($path, url('/'))){
           $path = str_replace(url('/'), '', $path);
           return file_exists(public_path($path));
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must either be a valid link or Image.';
    }
}

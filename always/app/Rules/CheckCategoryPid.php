<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Category;

class CheckCategoryPid implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($pid)
    {
        //传过来的值,当前id

        $this->pid=$pid;
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
        //                dd($this->pid);//当前页面ID
//        dd($value);//打印下拉框父ID
        $ids= Category::getChildsIds($this->pid);
        if(in_array($value,$ids)){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.CheckCategoryPid');//返回语言包设置的
//        return 'The validation error message.';
    }
}

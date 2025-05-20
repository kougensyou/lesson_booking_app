<?php

namespace App\Http\Requests\Api\Admin\MasterMaintenance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Api\Admin\MasterMaintenance\ItemIdUniqueRule;

class UpdateRequest extends FormRequest
{
    use \App\Http\Requests\Api\ValidationRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['master_id'] = 'required';
        $rules['master_name'] = 'required|max:30';

        foreach($this->common as $key => $common) {
            $rules["common.{$key}.item_id"] = [
                'required',
                'alpha_numeric',
                'max:20',
                // 新規追加時のユニークチェック
                new ItemIdUniqueRule($this->master_id, $common['item_id'], $common['state']),
            ];
            $rules["common.{$key}.item_code01"] = 'nullable|alpha_numeric|max:30';
            $rules["common.{$key}.item_code02"] = 'nullable|alpha_numeric|max:30';
            $rules["common.{$key}.item_code03"] = 'nullable|alpha_numeric|max:30';
            $rules["common.{$key}.item_code04"] = 'nullable|alpha_numeric|max:30';
            $rules["common.{$key}.item_code05"] = 'nullable|alpha_numeric|max:30';
            $rules["common.{$key}.item_value01"] = 'max:50';
            $rules["common.{$key}.item_value02"] = 'max:50';
            $rules["common.{$key}.item_value03"] = 'max:50';
            $rules["common.{$key}.item_value04"] = 'max:50';
            $rules["common.{$key}.item_value05"] = 'max:50';
            $rules["common.{$key}.item_number01"] = 'digits_between:0,15';
            $rules["common.{$key}.item_number02"] = 'digits_between:0,15';
            $rules["common.{$key}.item_number03"] = 'digits_between:0,15';
            $rules["common.{$key}.sort_seq"] = 'digits_between:0,3';
        }
        return $rules;
    }


    public function attributes()
    {
        $attr = [];
        foreach($this->common as $key => $common) {
            $attr["common.{$key}.item_id"] = \Lang::get('validation.attributes.item_id');
            $attr["common.{$key}.item_code01"] = \Lang::get('validation.attributes.item_code01');
            $attr["common.{$key}.item_code02"] = \Lang::get('validation.attributes.item_code02');
            $attr["common.{$key}.item_code03"] = \Lang::get('validation.attributes.item_code03');
            $attr["common.{$key}.item_code04"] = \Lang::get('validation.attributes.item_code04');
            $attr["common.{$key}.item_code05"] = \Lang::get('validation.attributes.item_code05');
            $attr["common.{$key}.item_value01"] = \Lang::get('validation.attributes.item_value01');
            $attr["common.{$key}.item_value02"] = \Lang::get('validation.attributes.item_value02');
            $attr["common.{$key}.item_value03"] = \Lang::get('validation.attributes.item_value03');
            $attr["common.{$key}.item_value04"] = \Lang::get('validation.attributes.item_value04');
            $attr["common.{$key}.item_value05"] = \Lang::get('validation.attributes.item_value05');
            $attr["common.{$key}.item_number01"] = \Lang::get('validation.attributes.item_number01');
            $attr["common.{$key}.item_number02"] = \Lang::get('validation.attributes.item_number02');
            $attr["common.{$key}.item_number03"] = \Lang::get('validation.attributes.item_number03');
            $attr["common.{$key}.sort_seq"] = \Lang::get('validation.attributes.sort_seq');
        }
        return $attr;
    }


    public function messages()
    {
        $required = \Lang::get('validation.required');
        $maxString = \Lang::get('validation.max.string');
        $alphaNumeric = \Lang::get('validation.alpha_numeric');
        $unique = \Lang::get('validation.unique');
        $digitsbetween = \Lang::get('validation.digits_between');

        $messages = [];
        $messages["master_id.required"] = $required;
        $messages["master_name.required"] = $required;
        $messages["master_name.max"] = $maxString;

        foreach ($this->common as $key => $value){
            $target = \Lang::get('validation.attributes.item_id') . " {$value['item_id']}：";
            $messages["common.{$key}.item_id.required"] = $required;
            $messages["common.{$key}.item_id.alpha_numeric"] = $target . $alphaNumeric;
            $messages["common.{$key}.item_id.max"] = $target . $maxString;
            $messages["common.{$key}.item_code01.alpha_numeric"] = $target . $alphaNumeric;
            $messages["common.{$key}.item_code01.max"] = $target . $maxString;
            $messages["common.{$key}.item_code02.alpha_numeric"] = $target . $alphaNumeric;
            $messages["common.{$key}.item_code02.max"] = $target . $maxString;
            $messages["common.{$key}.item_code03.alpha_numeric"] = $target . $alphaNumeric;
            $messages["common.{$key}.item_code03.max"] = $target . $maxString;
            $messages["common.{$key}.item_code04.alpha_numeric"] = $target . $alphaNumeric;
            $messages["common.{$key}.item_code04.max"] = $target . $maxString;
            $messages["common.{$key}.item_code05.alpha_numeric"] = $target . $alphaNumeric;
            $messages["common.{$key}.item_code05.max"] = $target . $maxString;
            $messages["common.{$key}.item_value01.max"] = $target . $maxString;
            $messages["common.{$key}.item_value02.max"] = $target . $maxString;
            $messages["common.{$key}.item_value03.max"] = $target . $maxString;
            $messages["common.{$key}.item_value04.max"] = $target . $maxString;
            $messages["common.{$key}.item_value05.max"] = $target . $maxString;
            $messages["common.{$key}.item_number01.digits_between"] = $target . $digitsbetween;
            $messages["common.{$key}.item_number02.digits_between"] = $target . $digitsbetween;
            $messages["common.{$key}.item_number03.digits_between"] = $target . $digitsbetween;
            $messages["common.{$key}.sort_seq.digits_between"] = $target . $digitsbetween;
        }
        return $messages;
    }
}
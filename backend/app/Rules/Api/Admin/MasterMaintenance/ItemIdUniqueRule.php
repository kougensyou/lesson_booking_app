<?php

namespace App\Rules\Api\Admin\MasterMaintenance;

use Illuminate\Contracts\Validation\Rule;
use App\Models\MCommon;

class ItemIdUniqueRule implements Rule
{

    private $masterId;
    private $itemId;
    private $state;

    /**
     * Create a new rule instance.
     *
     * @param  string  $masterId
     * @param  string  $itemId
     * @param  string  $state
     * @return void
     */
    public function __construct($masterId, $itemId, $state)
    {
        $this->masterId = $masterId;
        $this->itemId = $itemId;
        $this->state = $state;
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
        // 新規追加時のユニークチェック
        if ($this->state === 'add') {
            $target = MCommon::where('item_id', $value)->where('master_id', $this->masterId)->first();
            if (isset($target)) {
                return false;
            }
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
        return \Lang::get('validation.attributes.item_id') . " {$this->itemId}：" . trans('validation.unique');
    }
}

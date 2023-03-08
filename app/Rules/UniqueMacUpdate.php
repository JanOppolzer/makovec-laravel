<?php

namespace App\Rules;

use App\Models\Device;
use App\Services\MacService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueMacUpdate implements ValidationRule
{
    public $macService;

    public function __construct()
    {
        $this->macService = new MacService;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $mac = strtolower(preg_replace('/(\W)/', '', $value));
        $id = request()->segment(2);

        if (Device::whereMac($mac)->whereNot('id', $id)->count() !== 0) {
            $fail(__('devices.uniqueness_required'));
        }

        if ($this->macService->isReserved($mac)) {
            $fail(__('devices.reserved_mac_address'));
        }
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpcA implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Ensure the value is exactly 12 digits
        if (!preg_match('/^\d{12}$/', $value)) {
            $fail("The $attribute must be exactly 12 digits.");
            return;
        }

        // Compute the check digit
        $digits = str_split($value);
        $checkDigit = array_pop($digits); // Last digit is the check digit

        $sumOdd = 0;
        $sumEven = 0;

        foreach ($digits as $index => $digit) {
            if ($index % 2 === 0) {
                $sumOdd += $digit * 3;
            } else {
                $sumEven += $digit;
            }
        }

        $total = $sumOdd + $sumEven;
        $calculatedCheckDigit = (10 - ($total % 10)) % 10;

        if ($checkDigit != $calculatedCheckDigit) {
            $fail("The $attribute is not a valid UPC-A barcode.");
        }
    }
}

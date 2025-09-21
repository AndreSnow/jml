<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cnpj implements Rule
{
    public function passes($attribute, $value)
    {
        $cnpj = preg_replace('/\D/', '', (string) $value);
        if (strlen((string) $cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', (string) $cnpj)) {
            return false;
        }

        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            for ($m = $t - 7, $i = 0; $i < $t; $i++) {
                $d += $cnpj[$i] * $m--;
                if ($m < 2) {
                    $m = 9;
                }
            }

            $c = ((10 * $d) % 11) % 10;
            if ($cnpj[$i] != $c) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute must be a valid CNPJ.';
    }
}

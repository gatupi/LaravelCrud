<?php

namespace App\Models\Mutators;

use \Exception;

trait CustomerMutator
{
    /**
     * @return string
     */

    public function getFullNameAttribute()
    {
        return $this->first_name  . (!empty($this->middle_name) ? " $this->middle_name " : " ") . $this->last_name;
    }

    /**
     * @return int
     */

    public function getAgeAttribute()
    {
        return calculateAge($this->date_of_birth);
    }

    /**
     * @return string
     */

    public function getHiddenCpfAttribute()
    {
        return hideCpf($this->cpf);
    }

    /**
     * @return string
     */
    public function getFormattedCpfAttribute()
    {
        return formatCpf($this->cpf);
    }

    /**
     *
     * @param string
     * @return void
     */

    public function setCpfAttribute($value)
    {
        if (!cpfIsValid($value))
            throw new Exception('Not a valid cpf! :/');
        $this->attributes['cpf'] = $value;
    }
}

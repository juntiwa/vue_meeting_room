<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class QuestionnaireStatus implements CastsAttributes
{
    protected $statuses = ['', 'wait for record', 'recorded', 'corrected'];
    protected $statusesThai = ['', 'รอบันทึก', 'บันทึก', 'ถูกแก้ไข'];
    protected $occupiedRawStatuses = [1, 2]; // 'booked', 'approved'

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return $this->statuses[$value] ?? '#na';
        // return $this->statusesThai[$value] ?? '#na';
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return array_search($value, $this->statuses);
    }

    public function __invoke(string $value): int
    {
        return array_search($value, $this->statuses);
    }

    public function getStatuses()
    {
        $locale = session('locale', config('app.locale'));
        return $locale === 'en' ? $this->statuses : $this->statusesThai;
    }

    public function getStatusLocale(int $index)
    {
        return session('locale', config('app.locale')) === 'en'
            ? $this->statuses[$index]
            : $this->statusesThai[$index];
    }

    public function getOccupiedRawStatuses()
    {
        return $this->occupiedRawStatuses;
    }
}

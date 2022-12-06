<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
    ];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    public function allowTo($ability)
    {
        if (is_string($ability)) {
            $ability = Ability::whereName($ability)->firstOrCreate(['name' => $ability]);
        }
        $this->abilities()->syncWithoutDetaching($ability);
    }
}

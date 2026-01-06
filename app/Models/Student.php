<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'apogee',
        'cin',
        'nom',
        'prenom',
        'email',
        'filiere',
        'niveau',
        'date_naissance',
        'telephone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
        ];
    }

    /**
     * Get the user associated with this student
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}

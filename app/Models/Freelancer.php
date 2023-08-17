<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    /**
     * This is one to one relationship belongsTo user model.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * These are the fillable field to apply 'Mass Assignment'.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'description',
        'hourly_rate',
        'profile_image_path',
        'title',
        'country',
        'verified',
        'gender',
        'birthday',
    ];

    protected $casts = [
        'birthday' => 'date'
    ];
}

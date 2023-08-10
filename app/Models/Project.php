<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    const TYPE_FIXED = 'fixed';
    const TYPE_HOURLY = 'hourly';

    // protected $fillable = [
    //     'title',
    //     'description',
    //     'status',
    //     'type',
    //     'budget',
    //     'user_id',
    //     'category_id',
    //     'attachments'
    // ];

    protected $guarded = [];

    /**
     * This is one to many relationship belongsTo user model.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public static function types() {
        return [
            self::TYPE_FIXED => 'fixed',
            self::TYPE_HOURLY =>'hourly',
        ];
    }
}

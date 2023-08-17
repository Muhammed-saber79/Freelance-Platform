<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    const TYPE_FIXED = 'fixed';
    const TYPE_HOURLY = 'hourly';

    protected $fillable = [
        'title',
        'description',
        'status',
        'type',
        'budget',
        'user_id',
        'category_id',
        'attachments'
    ];

    protected $casts = [
        'attachments' => 'json'
    ];
    
    /**
     * This is one to many relationship belongsTo user model.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany(
            Tag::class,
            'project_tag',
            'project_id',
            'tag_id',
            'id',
            'id'
        );
    }

    public static function types() {
        return [
            self::TYPE_FIXED => 'fixed',
            self::TYPE_HOURLY =>'hourly',
        ];
    }

    public function syncTags (array $tags) {
        $tags_id = [];
        foreach( $tags as $tag_name ) {
            $tag = Tag::firstOrCreate([
                'slug' => Str::slug($tag_name)
            ],[
                'name' => trim($tag_name)
            ]);

            $tags_id [] = $tag->id; 
        }

        $this->tags()->sync($tags_id);
    }
}

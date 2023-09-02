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
        'attachments' => 'json',
    ];
    
    /**
     * This is one to many relationship belongsTo user model.
     */
    public function client() {
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

    public function proposals () {
        return $this->hasMany(Proposal::class);
    }

    public function contract () {
        return $this->hasMany(Contract::class);
    }

    public function proposedFreelancers () {
        return $this->belongsToMany(User::class,
            'proposals',
            'project_id',
            'freelancer_id',
        )->withPivot([
            'description',
            'cost',
            'duration',
            'duration_unit',
            'status',
        ]);
    }

    /**
     * We considered this relation as next:
     * [projects]---hasMany--->[contracts]---hasMany--->[freelancers(users)]
     */
    public function contractedFreelancers () {
        return $this->belongsToMany(Contract::class,
            'proposals',
            'project_id',
            'freelancer_id',
        )->withPivot([
            'proposal_id',
            'cost',
            'type',
            'start_on',
            'end_on',
            'completed_on',
            'hours',
            'status'
        ]);
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

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * This is one to one relationship with Freelancer model.
     */
    public function freelancer() {
        return $this->hasOne(Freelancer::class, 'user_id', 'id')
            ->withDefault();
    }

    /**
     * This is one to many relationship with Project model.
     */
    public function projects() {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    /**
     * This is the first 'Accessor'
     * we can call it a 'getter' for image attribute
     * and because it is a getter it must return a value
     */
    public function getProfilePhotoUrlAttribute () {
        if ($this->freelancer->profile_image_path) {
            return asset('storage/' . $this->freelancer->profile_image_path);
        }

        return asset('images/default.png');
    }

    /**
     * This is the first 'Mutator'
     * we can call it a 'setter' for email attribute
     * and because it is a setter it doesn't return any value but, it changes a local attribute
     */
    public function setEmailAttribute ($value) {
        $this->attributes['email'] = Str::lower($value);
    }
}

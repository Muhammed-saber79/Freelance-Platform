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
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at'
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
     * This is one to many relationship with Proposal model.
     * The User model represents as a Freelancer model here.
     */
    public function proposals () {
        return $this->hasMany(Proposal::class, 'freelancer_id', 'id');
    }

    /**
     * This is one to many relationship with Proposal model.
     * The User model represents as a Freelancer model here.
     */
    public function contracts () {
        return $this->hasMany(Contract::class, 'freelancer_id', 'id');
    }

    /**
     * This is many to many relationship between users & proejcts on the proposals(pivot table).
     * We type the current local_id as freelancer_id because we consider the freelancer as user table.
     */
    public function proposedProjects () {
        return $this->belongsToMany(Project::class,
            'proposals',
            'freelancer_id',
            'project_id',
        )->withPivot([
            'description',
            'cost',
            'duration',
            'duration_unit',
            'status',
        ]);
    }

    /**
     * This is many to many relationship between users & projects on contracts(pivot table).
     * We type the current local_id as freelancer_id because we consider the freelancer as user table.
     */
    public function contractedProjects () {
        return $this->belongsToMany(
            Project::class,
            'contracts',
            'freelancer_id',
            'project_id'
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

    public function routeNotificationForVonage($notification = null)
    {
        return $this->mobile_number;
    }

    public function routeNotificationForNepras($notification = null)
    {
        return $this->mobile_number;
    }

    /**
     * This is used to change the notification channel name that users use to receive notifications.
     */
    /*
    public function receiveBroadcastNotificationsOn()
    {
        return 'Notifications.' . $this->id;
    }
    */
}

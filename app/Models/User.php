<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1; // administrator
    const USER_ROLE_ID = 2; // regular user

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

    # Use this  method to get all the posts of a user
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }


    ### Note: The AUTH user ( Auth::user()->id  ) ---> will always be the follower

    # Use this method to get all the followers of a user
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
        //following_id can show who are following me
    }

    # Follows table                                 Users table
    # follower_id    following_id                   id        name
    #    1                2                         1        John Smith
    #    1                3                         2        Tim Watson
    #    2                4                         3        Jane Doe
    #    3                2                          4        User12345

    # $user = $this->user->findOrFail(1);
    #  foreach($user->followers as $follower){
    #    {{ $follower->following_id }}  ----> id 1 is following id 2, id 1 is following 3
    # }



    # One to many method relationship hasMany()
    # Use this method to get all the users the the AUTH user is following
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    # Check if the AUTH user is already following a user
    public function isFollowed()
    {
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        # Note: Auth::user()->id -------> the follower
        # First, in "$this->followers()" we retrieved the records, the from that records, search
        # searching  for the AUTH user from the follower_id column ( where('follower_id', Auth::user()->id) )
    }
}

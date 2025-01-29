<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'role',
        'last_logged_in_at',
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
     * Get the friend requests sent by this user.
     */
    public function sentRequests()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    /**
     * Get the friend requests received by this user.
     */
    public function receivedRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    /**
     * Get the user's accepted friends.
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'sender_id', 'receiver_id')
                    ->wherePivot('status', 'accepted')
                    ->orWhere(function ($query) {
                        $query->where('receiver_id', $this->id)
                              ->where('status', 'accepted');
                    });
    }


    // Fetch friends of friends (mutual friends)
    public function mutualFriends()
    {
        $userId = auth()->id(); // Get the logged-in user's ID

        // Get the logged-in user's friends (IDs)
        $userFriends = $this->friends()->pluck('users.id'); // Specify 'users.id' to avoid ambiguity

        // Get friends of the logged-in user's friends (friends of friends)
        $friendsOfFriends = User::whereIn('users.id', $userFriends) // Specify 'users.id' to avoid ambiguity
                                ->with('friends') // Eager load friends
                                ->get()
                                ->pluck('friends') // Get the friends of those users
                                ->flatten()
                                ->pluck('id'); // Get all the IDs of the friends of friends

        // Exclude the logged-in user and their direct friends
        $mutualFriendsIds = $friendsOfFriends->diff($userFriends)->diff([$userId]);

        // Get the mutual friends that are not the logged-in user or their direct friends
        return User::whereIn('users.id', $mutualFriendsIds)->get(); // Specify 'users.id' to avoid ambiguity
    }
    

    

}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'banned_at' => 'datetime',
    ];

   
     /**
     * Get the notes for the user.
     *
     */
    public function notes() 
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the pages for the user.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the workspaces for the user.
     */
    public function workspaces() {
        return $this->belongsToMany(Workspace::class,'user_workspaces')
                ; 
    }
     
    public function workspaceOwner(){
        return $this->hasMany(Workspace::class,'owner_id');
    }

    
}

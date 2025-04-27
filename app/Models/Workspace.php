<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'owner_id',
        'description',
        'color',
        'workspace_ref',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the workspace.
     */
    public function owner()
    {
        return $this->belongsTo(User::class,'owner_id');
    }

    /**
     * Get the pages in this workspace.
     */
    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_workspaces');
    } 
}
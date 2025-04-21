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
        'description',
        'color',
        'is_default',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pages in this workspace.
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the notes in this workspace.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
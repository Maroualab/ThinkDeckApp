<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Workspace;

class DefaultWorkspacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            if ($user->workspaces()->count() === 0) {
                $workspace = $user->workspaces()->create([
                    'name' => 'Personal',
                    'icon' => '👤',
                    'description' => 'Your default workspace',
                    'is_default' => true,
                ]);
                
                // Update existing pages and notes to belong to this workspace
                $user->pages()->update(['workspace_id' => $workspace->id]);
                $user->notes()->update(['workspace_id' => $workspace->id]);
            }
        }
    }
}
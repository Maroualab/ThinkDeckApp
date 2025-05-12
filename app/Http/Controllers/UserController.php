<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCount = User::count();
        $pageCount = Page::all()->count();
        return view('admin.dashboard', compact('userCount', 'pageCount'));
    }
    public function userDisplay(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', $searchTerm)
              ->orWhere('email', 'LIKE', $searchTerm);
            });
        }

        if ($request->filled('role')) {
            $query->where('is_admin', $request->role);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $users = $query->paginate(5);
        $userCount = User::all()->count();
        $adminUsers = User::where('is_admin', true)->count();
        $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();


        return view('admin.users', compact('users', 'userCount', 'adminUsers', 'newUsers'));
    }


    public function updateStatusUser(User $user)
    {
        // dd(!$user->is_admin);
        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->back();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

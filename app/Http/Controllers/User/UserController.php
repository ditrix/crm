<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isHead(), 403);

        $users = User::with('roles')->latest()->get();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isHead(), 403);

        $roles = $this->availableRoles();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->guardRoleAccess($request->role);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', __('messages.user_created'));
    }

    public function edit(User $user): View
    {
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isHead(), 403);

        $roles = $this->availableRoles();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->guardRoleAccess($request->role);

        // Prevent demoting yourself
        abort_if($user->id === auth()->id() && $request->role !== auth()->user()->getRoleNames()->first(), 403);

        $user->update([
            'name'      => $request->name,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', __('messages.user_updated'));
    }

    private function availableRoles(): array
    {
        // Head cannot create/manage admins
        if (auth()->user()?->isHead()) {
            return [UserRole::Head->value, UserRole::Manager->value];
        }

        return UserRole::values();
    }

    private function guardRoleAccess(string $role): void
    {
        if (auth()->user()?->isHead() && $role === UserRole::Admin->value) {
            abort(403);
        }
    }
}

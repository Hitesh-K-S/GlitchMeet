<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\StorableEvents\UserUpdatedProfile;

class UpdateUserProfile
{
    public function handle(User $user, array $data): User
    {
        $validated = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
        ])->validate();

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        event(new UserUpdatedProfile(
            $user->id,
            $validated['bio'],
        ));

        return $user;
    }
}

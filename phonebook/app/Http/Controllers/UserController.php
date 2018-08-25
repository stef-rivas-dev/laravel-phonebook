<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a single user's data
     *
     * @param  \App\User $user
     * @return \App\User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function listContacts(User $user)
    {
        if ($user instanceof User) {
            return response($user->contacts);
        } else {
            return response()->toJson([
                'data' => [],
                'errors' => [
                    'User not found.',
                ],
            ]);
        }
    }

    /**
     * Delete a user
     *
     * @param \App\User
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user) {
        $user->delete();
        return response()->json(null, 204);
    }
}

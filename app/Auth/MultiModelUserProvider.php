<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Session;

class MultiModelUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     */
    public function retrieveByCredentials(array $credentials)
    {
        // This method is only used if Auth::attempt() is called
        // Since we do manual authentication in controller, this won't be used
        return null;
    }

    /**
     * Retrieve a user by their unique identifier.
     * This is used when Laravel tries to restore user from session.
     * 
     * To handle ID collisions between User and Siswa tables,
     * we store the model type in session and use it to determine which table to query.
     */
    public function retrieveById($id)
    {
        // Check if we have a stored model type in session
        $modelType = Session::get('auth_model_type');

        if ($modelType === 'siswa') {
            $siswa = \App\Models\Siswa::where('id', $id)->first();
            if ($siswa) {
                return $siswa;
            }
        }

        // Default to User model (for admin/guru)
        $userModel = $this->createModel();
        $user = $userModel->where($userModel->getKeyName(), $id)->first();
        if ($user) {
            return $user;
        }

        // If User not found and we haven't tried Siswa yet, try it now
        if ($modelType !== 'siswa') {
            $siswa = \App\Models\Siswa::where('id', $id)->first();
            if ($siswa) {
                return $siswa;
            }
        }

        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     */
    public function retrieveByToken($identifier, $token)
    {
        // Check session for model type hint
        $modelType = Session::get('auth_model_type');

        if ($modelType === 'siswa') {
            $siswa = \App\Models\Siswa::where('id', $identifier)->first();
            if ($siswa && $siswa->getRememberToken() && hash_equals($siswa->getRememberToken(), $token)) {
                return $siswa;
            }
        } else {
            // Try User model
            $user = $this->createModel()->where($this->model->getKeyName(), $identifier)->first();
            if ($user && $user->getRememberToken() && hash_equals($user->getRememberToken(), $token)) {
                return $user;
            }
        }

        // Fallback: try both models if not found
        $siswa = \App\Models\Siswa::where('id', $identifier)->first();
        if ($siswa && $siswa->getRememberToken() && hash_equals($siswa->getRememberToken(), $token)) {
            return $siswa;
        }

        return null;
    }
}

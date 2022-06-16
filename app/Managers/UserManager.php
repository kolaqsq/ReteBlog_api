<?php

namespace App\Managers;

use App\Models\File;
use App\Models\User;
use App\Traits\HasUsername;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserManager
{
    use HasUsername;

    private ?User $user;

    public function __construct(?User $user = null)
    {
        $this->user = $user;
    }

    /**
     * @throws ValidationException
     */
    public function auth($email, $password, $remember = false)
    {
        $this->user = User::findByEmail($email);

        if (!$this->user) {
            throw ValidationException::withMessages([
                                                        "email" => 'Неверный email и/или пароль.',
                                                    ]);
        }

        if (!Hash::check($password, $this->user->password)) {
            throw ValidationException::withMessages([
                                                        "email" => 'Неверный email и/или пароль.',
                                                    ]);
        }

        $ttl = ($remember) ? env('JWT_TTL_REMEMBER') : env('JWT_TTL');

        return auth()->setTTL($ttl)->login($this->user);
    }

    public function register(array $params)
    {
        $this->create($params);

        $ttl = env('JWT_TTL');
        return auth()->setTTL($ttl)->login($this->user);
    }

    public function create(array $params): User
    {
        if (isset($params['username'])) {
            $params['username'] = $this->prepareUsername($params['username']);
        } else {
            $params['username'] = $this->getUsernameFromEmail($params['email']);
        }

        $params['password'] = Hash::make($params['password']);

        $this->user = app(User::class);
        $this->user->fill($params);
        $this->user->save();

        $this->user->assignRole('user');

//        $this->statManager->create(Stat::USER_MODEL, $this->user->id, Stat::CREATED_ACTION);

        return $this->user;
    }

    public function update(User $user, array $params): void
    {
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        if ($user->email != $params['email']) {
            $user->email_verified_at = null;
        }

        $user->fill($params);
        $user->save();
    }

    public function updateAvatar($user, array $params)
    {
        $fileManager = app(FileManager::class);

        if (isset($user->file_id)) {
            $fileManager->delete($user, File::find($user->file_id)->filename);
        }

        $file = $fileManager->save($params);

        $user->file_id = $file->id;
        $user->save();
    }

    /**
     * @throws ValidationException
     */
    public function delete($user, $password)
    {
        $fileManager = app(FileManager::class);

        if (Hash::check($password, $user->password)) {
            if (isset($user->file_id)) {
                $fileManager->delete($user, File::find($user->file_id)->filename);
            }
            $user->delete();
        } else {
            throw ValidationException::withMessages([
                                                        "email" => 'Неверный пароль.',
                                                    ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function checkUsername($username): void
    {
        $this->user = User::findByUsername($username);

        if ($this->user) {
            throw ValidationException::withMessages([
                                                        "username" => 'Имя пользователя занято.',
                                                    ]);
        }
    }
}

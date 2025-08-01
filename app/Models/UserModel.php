<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['username', 'email', 'password', 'name'];
    protected $useTimestamps = true;

    public function getUserByUsername(string $username)
    {
        return $this
            ->where('username', $username)
            ->first();
    }

    public function updateUserPassword(int $id, string $password)
    {
        $this->update($id, [
            'password' => $password, 
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getUserByEmail(string $email)
    {
        return $this->where('email', $email)
                    ->first();
    }
}

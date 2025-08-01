<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        return view('Registration/register');
    }

    public function doRegister()
    {
        $session = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $name = $this->request->getPost('name');

        // Validasi username/email unik
        if ($userModel->getUserByUsername($username)) {
            $session->setFlashdata('error', 'Username already exists.');
            return redirect()->to('/register')->withInput();
        }
        if ($userModel->getUserByEmail($email)) {
            $session->setFlashdata('error', 'Email already exists.');
            return redirect()->to('/register')->withInput();
        }
        // Validasi password sama
        if ($password !== $confirmPassword) {
            $session->setFlashdata('error', 'confirm password is not the same.');
            return redirect()->to('/register')->withInput();
        }
        // Simpan user baru
        $userModel->save([
            'username' => $username,
            'email' => $email,
            'name' => $name,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $session->setFlashdata('success', 'Registration successfully please login.');
        return redirect()->to('/login');
    }
}
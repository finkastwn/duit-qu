<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        log_message('debug', '==== Register: Showing register page ====');
        $session = session();
        if ($session->get('isLoggedIn')) {
            log_message('debug', 'User already logged in, redirecting to dashboard');
            return redirect()->to('/');
        }
        return view('Registration/register');
    }

    public function doRegister()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        log_message('debug', '==== Register: Processing registration attempt ====');
        log_message('debug', "Registration attempt for username: $username, name: $name, email: $email");

        if (empty($username) || empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            $session->setFlashdata('error', 'All fields are required.');
            return redirect()->to('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $session->setFlashdata('error', 'Please enter a valid email address.');
            return redirect()->to('/register');
        }

        if ($password !== $confirm_password) {
            $session->setFlashdata('error', 'Password confirmation does not match.');
            return redirect()->to('/register');
        }

        if ($this->userModel->isUsernameExists($username)) {
            $session->setFlashdata('error', 'Username already exists. Please choose another username.');
            return redirect()->to('/register');
        }

        if ($this->userModel->isEmailExists($email)) {
            $session->setFlashdata('error', 'Email already exists. Please use another email address.');
            return redirect()->to('/register');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userData = [
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];

        try {
            $this->userModel->insert($userData);
            log_message('debug', 'User registered successfully: ' . $username);
            
            $session->setFlashdata('success', 'Registration successful! Please login with your new account.');
            return redirect()->to('/login');
        } catch (\Exception $e) {
            log_message('error', 'Registration failed: ' . $e->getMessage());
            $session->setFlashdata('error', 'Registration failed. Please try again.');
            return redirect()->to('/register');
        }
    }
}

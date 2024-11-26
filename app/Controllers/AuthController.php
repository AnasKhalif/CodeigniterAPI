<?php

namespace App\Controllers;

// use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends ResourceController
{
    public function register()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

        if (!isset($data['password'])) {
            return $this->fail('Password is required');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        if ($model->registerUser($data)) {
            return $this->response->setStatusCode(200)
                ->setJSON(['message' => 'User successfully registered']);
        }

        return $this->fail('Registration failed');
    }

    public function login()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

        if (empty($data['username']) || empty($data['password'])) {
            return $this->fail('Username and password are required');
        }

        $user = $model->loginUser($data['username'], $data['password']);

        if ($user) {
            return $this->respond([
                'message' => 'Login successful',
                'user' => $user
            ]);
        }

        return $this->failUnauthorized('Invalid username or password');
    }
}

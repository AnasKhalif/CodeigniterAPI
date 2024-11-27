<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    private $secretKey = 's9v37w4Q@39!j2DbLXp8rmV9c2A6Z6Gv%';
    public function register()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['errors' => $this->validator->getErrors()]);
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
            $jwt = $this->generateJWT($user);
            return $this->respond([
                'message' => 'Login successful',
                'token' => $jwt,
                'user' => $user
            ]);
        }

        return $this->failUnauthorized('Invalid username or password');
    }
    private function generateJWT($user)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'username' => $user['username'],
            'id' => $user['id']
        );

        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

        return $jwt;
    }
}

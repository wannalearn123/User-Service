<?php

namespace App\Controllers\UserService;

use App\Controllers\BaseController;
use App\Models\AkunModel;
use CodeIgniter\API\ResponseTrait;

class AkunController extends BaseController
{
    use ResponseTrait;

    /**
     * Fitur Register
     * Menggunakan fungsi createAkun dari Model
     */
    public function register()
    {
        $model = new AkunModel();

        // Data diambil dari input JSON/Form
        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'nama'     => $this->request->getVar('nama'), // Sesuai allowedFields model Anda
        ];

        // Memanggil fungsi createAkun yang Anda buat di Model
        $userId = $model->createAkun($data);

        if ($userId) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Registrasi user berhasil',
                'user_id' => $userId
            ]);
        }

        return $this->fail($model->errors());
    }

    /**
     * Fitur Login
     * Menggunakan fungsi getAkunByUsernameOrEmail dari Model
     */
    public function login()
    {
        $model = new AkunModel();
        
        $identifier = $this->request->getVar('identifier'); // Bisa email atau username
        $password   = $this->request->getVar('password');

        // Memanggil fungsi pencarian custom yang Anda buat di Model
        $user = $model->getAkunByUsernameOrEmail($identifier);

        if ($user && password_verify($password, $user['password'])) {
            
            // Generate token sederhana
            $token = bin2hex(random_bytes(16));

            // Menggunakan fungsi updateAkun dari Model untuk simpan token
            $model->updateAkun($user['id'], [
                'token' => $token
            ]);

            return $this->respond([
                'user_id' => $user['id'],
                'name'    => $user['nama'],
                'token'   => $token
            ]);
        }

        return $this->failUnauthorized('Kredensial tidak valid');
    }
}
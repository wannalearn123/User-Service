<?php

namespace App\Controllers\UserService;

use App\Controllers\BaseController;
use App\Models\AkunPeranModel;
use CodeIgniter\API\ResponseTrait;

class AkunPeranController extends BaseController
{
    use ResponseTrait;

    /**
     * Menampilkan semua data hubungan akun dan peran
     */
    public function index()
    {
        $model = new AkunPeranModel();
        $data  = $model->getAllAkunPeran();
        
        return $this->respond($data);
    }

    /**
     * Menambahkan Peran ke User (Assign)
     * Menggunakan fungsi assignPeranToUser dari Model
     */
    public function create()
    {
        $model = new AkunPeranModel();

        $akunId  = $this->request->getVar('akun_id');
        $peranId = $this->request->getVar('peran_id');

        // Memanggil fungsi custom dari model
        $resultId = $model->assignPeranToUser($akunId, $peranId);

        if ($resultId) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Peran berhasil diberikan kepada user',
                'id'      => $resultId
            ]);
        }

        return $this->fail('Gagal memberikan peran');
    }

    /**
     * Menghapus Peran dari User (Revoke)
     * Menggunakan fungsi revokePeranFromUser dari Model
     */
    public function deleteRole()
    {
        $model = new AkunPeranModel();

        $akunId  = $this->request->getVar('akun_id');
        $peranId = $this->request->getVar('peran_id');

        if ($model->revokePeranFromUser($akunId, $peranId)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => 'Peran user berhasil dicabut'
            ]);
        }

        return $this->failNotFound('Data hubungan akun dan peran tidak ditemukan');
    }
}
<?php

namespace App\Controllers\UserService;

use App\Controllers\BaseController;
use App\Models\PeranModel;
use CodeIgniter\API\ResponseTrait;

class PeranController extends BaseController
{
    use ResponseTrait;

    /**
     * Mengambil semua daftar peran (Role)
     * Menggunakan fungsi getAllPeran dari Model
     */
    public function index()
    {
        $model = new PeranModel();
        $data  = $model->getAllPeran();
        
        return $this->respond($data);
    }

    /**
     * Menampilkan detail satu peran berdasarkan ID
     */
    public function show($id = null)
    {
        $model = new PeranModel();
        $data  = $model->getPeranById($id);

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound("Peran dengan ID $id tidak ditemukan");
    }

    /**
     * Membuat peran baru (misal: Admin, Kasir, Pelanggan)
     * Menggunakan fungsi createPeran dari Model
     */
    public function create()
    {
        $model = new PeranModel();
        
        $data = [
            'name'        => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
        ];

        // Validasi otomatis dijalankan oleh Model sesuai $validationRules
        $peranId = $model->createPeran($data);

        if ($peranId) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Peran baru berhasil dibuat',
                'id'      => $peranId
            ]);
        }

        return $this->fail($model->errors());
    }

    /**
     * Memperbarui data peran
     * Menggunakan fungsi updatePeran dari Model
     */
    public function update($id = null)
    {
        $model = new PeranModel();
        $data  = $this->request->getRawInput(); // Mendapatkan data dari PUT/PATCH

        if ($model->updatePeran($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => "Data peran ID $id berhasil diperbarui"
            ]);
        }

        return $this->fail($model->errors());
    }

    /**
     * Menghapus peran (Soft Delete)
     * Menggunakan fungsi deletePeran dari Model
     */
    public function delete($id = null)
    {
        $model = new PeranModel();
        
        if ($model->deletePeran($id)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => 'Peran berhasil dihapus'
            ]);
        }

        return $this->failNotFound("Gagal menghapus, peran ID $id tidak ditemukan");
    }
}

<?php

namespace App\Controllers\UserService;

use App\Controllers\BaseController;
use App\Models\PeranMenuModel;
use CodeIgniter\API\ResponseTrait;

class PeranMenuController extends BaseController
{
    use ResponseTrait;

    /**
     * Menampilkan semua daftar izin (permissions) yang ada
     */
    public function index()
    {
        $model = new PeranMenuModel();
        $data  = $model->getAllPeranMenu();
        
        return $this->respond($data);
    }

    /**
     * Memberikan izin menu ke peran tertentu (Set Permission)
     * Menggunakan fungsi setPermissionMenu dari Model
     */
    public function create()
    {
        $model = new PeranMenuModel();

        $peranId = $this->request->getVar('peran_id');
        $menuId  = $this->request->getVar('menu_id');
        
        // Mengambil nilai boolean untuk CRUD (default false jika tidak diisi)
        $c = (bool) $this->request->getVar('c');
        $r = (bool) $this->request->getVar('r');
        $u = (bool) $this->request->getVar('u');
        $d = (bool) $this->request->getVar('d');

        if ($model->setPermissionMenu($peranId, $menuId, $c, $r, $u, $d)) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Izin menu berhasil diterapkan pada peran tersebut'
            ]);
        }

        return $this->fail('Gagal menetapkan izin menu');
    }

    /**
     * Melihat daftar menu yang boleh diakses oleh peran tertentu
     */
    public function showByPeran($peranId = null)
    {
        $model = new PeranMenuModel();
        $data  = $model->getMenuByPeran($peranId);

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound("Tidak ada izin menu yang ditemukan untuk Peran ID $peranId");
    }

    /**
     * Mencabut izin menu dari peran (Revoke)
     */
    public function deletePermission()
    {
        $model = new PeranMenuModel();

        $peranId = $this->request->getVar('peran_id');
        $menuId  = $this->request->getVar('menu_id');

        if ($model->revokePermissionMenu($peranId, $menuId)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => 'Izin menu berhasil dicabut dari peran tersebut'
            ]);
        }

        return $this->failNotFound('Data izin tidak ditemukan');
    }
}

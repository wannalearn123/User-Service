<?php

namespace App\Controllers\UserService;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use CodeIgniter\API\ResponseTrait;

class MenuController extends BaseController
{
    use ResponseTrait;

    /**
     * Menampilkan semua menu dengan struktur hirarki (Parent-Children)
     * Menggunakan fungsi getFullMenuHierarchy dari Model
     */
    public function index()
    {
        $model = new MenuModel();
        $data  = $model->getFullMenuHierarchy(); // Mengambil menu bertingkat
        
        return $this->respond($data);
    }

    /**
     * Membuat menu baru
     * Menggunakan fungsi createMenu dari Model
     */
    public function create()
    {
        $model = new MenuModel();
        
        $data = [
            'nama'   => $this->request->getVar('nama'),   // Sesuaikan dengan model
            'url'    => $this->request->getVar('url'),
            'icon'   => $this->request->getVar('icon'),
            'parent' => $this->request->getVar('parent'), // Bisa diisi ID parent atau null
            'order'  => $this->request->getVar('order'),
        ];

        $menuId = $model->createMenu($data);

        if ($menuId) {
            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Menu berhasil ditambahkan',
                'id'      => $menuId
            ]);
        }

        return $this->fail('Gagal menambahkan menu');
    }

    /**
     * Memperbarui menu berdasarkan ID
     * Menggunakan fungsi updateMenu dari Model
     */
    public function update($id = null)
    {
        $model = new MenuModel();
        $data  = $this->request->getRawInput(); // Mengambil data PUT/PATCH

        if ($model->updateMenu($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => "Menu ID $id berhasil diperbarui"
            ]);
        }

        return $this->fail("Gagal memperbarui menu ID $id");
    }

    /**
     * Menghapus menu
     * Menggunakan fungsi deleteMenu dari Model
     */
    public function delete($id = null)
    {
        $model = new MenuModel();
        
        if ($model->deleteMenu($id)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => 'Menu berhasil dihapus'
            ]);
        }

        return $this->failNotFound('Menu tidak ditemukan');
    }
}
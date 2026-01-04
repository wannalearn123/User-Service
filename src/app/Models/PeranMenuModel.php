<?php

namespace App\Models;

use CodeIgniter\Model;

class PeranMenuModel extends Model
{
    protected $table            = 'peran_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['peran_id', 'menu_id', 'c', 'r', 'u', 'd'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Create function
    public function createPeranMenu(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    // Read function
    public function getPeranMenu(int $id): ?array
    {
        return $this->find($id);
    }
    public function getAllPeranMenu(): array
    {
        return $this->findAll();
    }

    // Update function
    public function updatePeranMenu(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    // Delete function
    public function deletePeranMenu(int $id): bool
    {
        return $this->delete($id);
    }

    // Set Permission Menu ke Peran
    public function setPermissionMenu(int $peranId, int $menuId, bool $create, bool $read, bool $update, bool $delete): bool
    {
        // Implementasi logika untuk menetapkan izin menu ke peran
        $data = [
            'peran_id' => $peranId,
            'menu_id' => $menuId,
            'c' => $create,
            'r' => $read,
            'u' => $update,
            'd' => $delete,
        ];
        $this->createPeranMenu($data);
        return true;
    }

    // Check Permission Menu dari Peran
    public function checkPermissionMenu(int $peranId, int $menuId): ?array
    {
        return $this->where('peran_id', $peranId)
                    ->where('menu_id', $menuId)
                    ->first();
    }

    // Revoke Permission Menu dari Peran
    public function revokePermissionMenu(int $peranId, int $menuId): bool
    {
        $permission = $this->checkPermissionMenu($peranId, $menuId);
        if ($permission) {
            return $this->delete($permission['id']);
        }
        return false;
    }

    // Get Menu by Peran
    public function getMenuByPeran(int $peranId): array
    {
        return $this->where('peran_id', $peranId)
                    ->findAll();
    }
}

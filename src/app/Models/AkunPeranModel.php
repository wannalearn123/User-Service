<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunPeranModel extends Model
{
    protected $table            = 'akun_peran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['akun_id', 'peran_id', 'identity'];

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
    public function createAkunPeran(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    // Read function
    public function getAkunPeran(int $id): ?array
    {
        return $this->find($id);
    }
    public function getAllAkunPeran(): array
    {
        return $this->findAll();
    }

    // Update function
    public function updateAkunPeran(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    // Delete function
    public function deleteAkunPeran(int $id): bool
    {
        return $this->delete($id);
    }

    // Assign Peran ke User
    public function assignPeranToUser(int $akunId, int $peranId): int
    {
        return $this->createAkunPeran([
            'akun_id' => $akunId,
            'peran_id' => $peranId,
        ]);
    }

    // Revoke Peran dari User
    public function revokePeranFromUser(int $akunId, int $peranId): bool
    {
        $akunPeran = $this->where('akun_id', $akunId)
                         ->where('peran_id', $peranId)
                         ->first();
        if ($akunPeran) {
            return $this->delete($akunPeran['id']);
        }
        return false;
    }
}

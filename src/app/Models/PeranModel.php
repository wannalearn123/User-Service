<?php

namespace App\Models;

use CodeIgniter\Model;

class PeranModel extends Model
{
    protected $table            = 'peran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|is_unique[peran.name]',
    ];
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
    public function createPeran(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    // Read function
    public function getPeranById(int $id): ?array
    {
        return $this->find($id);
    }
    public function getAllPeran(): array
    {
        return $this->findAll();
    }

    // Update function
    public function updatePeran(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    // Delete function
    public function deletePeran(int $id): bool
    {
        return $this->delete($id);
    }

}

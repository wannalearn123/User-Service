<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table            = 'akun';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'password',
        'nama',
        'token',
    ];

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
        'username' => 'required|min_length[3]|max_length[64]|is_unique[akun.username]',
        'email'    => 'required|valid_email|max_length[255]|is_unique[akun.email]',
        'password' => 'required|max_length[255]',
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
    public function createAkun(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    // Read function
    public function getAkunById(int $id): ?array
    {
        return $this->find($id);
    }

    public function getAllAkun(): ?array
    {
        return $this->findAll();
    }

    // Update function
    public function updateAkun(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    // Delete function
    public function deleteAkun(int $id): bool
    {
        return $this->delete($id);
    }

    // Hash password before saving
    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    // Get akun by username or email
    public function getAkunByUsernameOrEmail(string $identifier): ?array
    {
        return $this->where('username', $identifier)
                    ->orWhere('email', $identifier)
                    ->first();
    }

    // Get akun with peran
    public function getAkunWithPeran(int $akunId): ?array
    {
        $builder = $this->db->table('akun as a');
        $builder->select('a.*, p.name as peran_name, p.description as peran_description');
        $builder->join('akun_peran as ap', 'a.id = ap.akun_id', 'left');
        $builder->join('peran as p', 'ap.peran_id = p.id', 'left');
        $builder->where('a.id', $akunId);
        return $builder->get()->getRowArray();
    }
}

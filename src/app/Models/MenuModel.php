<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'url',
        'icon',
        'parent',
        'order',
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
    public function createMenu(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }

    // Read function
    public function getMenuById(int $id): ?array
    {
        return $this->find($id);
    }
    public function getAllMenu(): array
    {
        return $this->findAll();
    }

    // Update function
    public function updateMenu(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    // Delete function
    public function deleteMenu(int $id): bool
    {
        return $this->delete($id);
    }

    // Get menu by parent
    public function getMenuByParent(?int $parentId): array
    {
        return $this->where('parent', $parentId)->orderBy('order', 'ASC')->findAll();
    }

    // Get full menu hierarchy
    public function getFullMenuHierarchy(?int $parentId = null): array
    {
        $menus = $this->getMenuByParent($parentId);
        foreach ($menus as &$menu) {
            $menu['children'] = $this->getFullMenuHierarchy($menu['id']);
        }
        return $menus;
    }
}

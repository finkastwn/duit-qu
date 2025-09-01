<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomeCategoryModel extends Model
{
    protected $table = 'income_categories';
    protected $primaryKey = 'id';             
    
    protected $allowedFields = [
        'userId',
        'category'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
    
    public function categoryExistsForUser($categoryName, $userId)
    {
        return $this->where('category', $categoryName)
                   ->where('userId', $userId)
                   ->first() !== null;
    }
}


<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomeCategoryModel extends Model
{
    protected $table = 'income_categories';
    protected $primaryKey = 'id';             
    
    protected $allowedFields = [
        'userId',
        'category',
        'created_at'
    ];
}


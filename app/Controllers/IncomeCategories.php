<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IncomeCategoryModel;

class IncomeCategories extends BaseController
{
    protected $incomeCategoryModel;

    public function __construct()
    {
        $this->incomeCategoryModel = new IncomeCategoryModel();
    }

    // 1. Get all categories for current user
    public function index()
    {
        $userId = session()->get('user_id');
        $data['incomeCategories'] = $this->incomeCategoryModel
                                        ->where('userId', $userId)
                                        ->findAll();

        return view('income-categories/index', $data);
    }
}

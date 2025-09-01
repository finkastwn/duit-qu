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

    public function index()
    {
        $userId = session()->get('user_id');
        $data['incomeCategories'] = $this->incomeCategoryModel
                                        ->where('userId', $userId)
                                        ->findAll();

        return view('income-categories/index', $data);
    }

    public function store()
    {
        $session = session();
        $category = $this->request->getPost('category');
        $userId = session()->get('user_id');
        
        if (empty($category)) {
            $session->setFlashdata('error', 'Category name is required.');
            return redirect()->back();
        }
        
        if ($this->incomeCategoryModel->categoryExistsForUser($category, $userId)) {
            $session->setFlashdata('error', 'Category name already exists. Please choose a different name.');
            return redirect()->back();
        }
        
        $userData = [
            'category' => $category,
            'userId' => $userId
        ];

        try {
            $result = $this->incomeCategoryModel->insert($userData);
            
            if ($result) {
                $session->setFlashdata('success', 'Income category created successfully.');
                return redirect()->to('/income-categories');
            } else {
                $session->setFlashdata('error', 'Failed to create income category. Validation errors occurred.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Failed to create income category. Please try again.');
            return redirect()->back();
        }
    }
}

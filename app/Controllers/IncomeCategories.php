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
    
    public function edit($id)
    {
        $userId = session()->get('user_id');
        
        $category = $this->incomeCategoryModel
                        ->where('id', $id)
                        ->where('userId', $userId)
                        ->first();

        if (!$category) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Category not found']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $category]);
    }

    public function update($id)
    {
        $session = session();
        $category = $this->request->getPost('category');
        $userId = session()->get('user_id');
        
        $existingCategory = $this->incomeCategoryModel
                               ->where('id', $id)
                               ->where('userId', $userId)
                               ->first();

        if (!$existingCategory) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Category not found']);
        }

        if (empty($category)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Category name is required']);
        }

        $duplicateCheck = $this->incomeCategoryModel
                             ->where('category', $category)
                             ->where('userId', $userId)
                             ->where('id !=', $id)
                             ->first();

        if ($duplicateCheck) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Category name already exists']);
        }

        try {
            $result = $this->incomeCategoryModel->update($id, ['category' => $category]);
            
            if ($result) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Category updated successfully']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update category']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update category']);
        }
    }

    public function delete($id)
    {
        $session = session();
        $userId = $session->get('user_id');

        $category = $this->incomeCategoryModel
                        ->where('id', $id)
                        ->where('userId', $userId)
                        ->first();

        if (!$category) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Category not found']);
        }

        try {
            $this->incomeCategoryModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Category deleted']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete category']);
        }
    }
}

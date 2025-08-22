<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class IncomeCategories extends BaseController
{
    public function index()
    {
        // Mock data for income categories
        $data['incomeCategories'] = [
            [
                'id' => 1,
                'category' => 'Salary'
            ],
            [
                'id' => 2,
                'category' => 'Freelance'
            ],
            [
                'id' => 3,
                'category' => 'Investment Returns'
            ],
            [
                'id' => 4,
                'category' => 'Business Income'
            ],
            [
                'id' => 5,
                'category' => 'Rental Income'
            ],
            [
                'id' => 6,
                'category' => 'Commission'
            ],
            [
                'id' => 7,
                'category' => 'Bonus'
            ],
            [
                'id' => 8,
                'category' => 'Side Hustle'
            ]
        ];
        
        return view('income-categories/index', $data);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueConstraintToIncomeCategories extends Migration
{
    public function up()
    {
        $this->forge->addKey(['userId', 'category'], false, true);
        $this->forge->processIndexes('income_categories');
    }

    public function down()
    {
        $this->forge->dropKey('income_categories', 'userId_category');
    }
}

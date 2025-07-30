<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIncomeCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'userId'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('userId', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('income_categories');
    }

    public function down()
    {
        $this->forge->dropTable('income_categories');
    }
} 
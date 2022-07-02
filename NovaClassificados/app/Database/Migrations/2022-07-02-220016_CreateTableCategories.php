<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableCategories extends Migration
{
    public function up()
    {
    $this->forge->addField([
        'id'           =>[
            'type'          => 'INT',
            'constraint'    => 11,
            'unsigned'      => true,
            'auto_increment'=> true,
        ],
        'parent_id'           =>[
            'type'          => 'INT',
            'constraint'    => 11,
            'unsigned'      => true,
            'null'          => true,
        ],
        'nome'        => [
            'type'          => 'VARCHAR',
            'constraint'    => '100',
        ],
        'slug'        => [
            'type'          => 'VARCHAR',
            'constraint'    => '100',
        ],
        'created_at'        => [
            'type'          => 'DATETIME',
            'null'          => true,
            'default'       => null,
        ],
        'updated_at'        => [
            'type'          => 'DATETIME',
            'null'          => true,
            'default'       => null,
        ],
        'deleted_at'        => [
            'type'          => 'DATETIME',
            'null'          => true,
            'default'       => null,
        ],
        
        
     ]);

    $this->forge->addKey('id',true); //primary key
    $this->forge->addKey('slug'); //key
    $this->forge->addKey('parent_id'); //key

    $this->forge->createTable('categories');

}

public function down()
{
    
    $this->forge->dropTable('categories');

}
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AkunPeran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'akun_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'peran_id'   => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'identitas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('akun_id', 'akun', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('peran_id', 'peran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('akun_peran');
    }

    public function down()
    {
        $this->forge->dropTable('akun_peran');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'post_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'post_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'post_title_seo' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'post_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'post_type' => [
                'type' => 'ENUM',
                'constraint' => ['dashboard', 'page'],
                'default' => 'dashboard'
            ],
            'post_thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE, // Jika thumbnail bersifat opsional
            ],
            'post_description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE, // Jika deskripsi bersifat opsional
            ],
            'post_content' => [
                'type' => 'LONGTEXT',
                'null' => TRUE // Jika konten bersifat opsional
            ],
            'post_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP' // Definisi yang benar untuk timestamp
        ]);

        // Mengatur kunci asing untuk username
        $this->forge->addForeignKey('username', 'admin', 'username', 'CASCADE', 'CASCADE');
        $this->forge->addKey('post_id', TRUE); // Menambahkan primary key
        $this->forge->createTable('posts'); // Membuat tabel
    }

    public function down()
    {
        $this->forge->dropTable('posts'); // Menghapus tabel
    }
}

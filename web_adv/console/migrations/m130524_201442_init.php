<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('pessoa', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull(),
            'lastname' => $this->string(45)->notNull(),
            'birthday_date' => $this->date()->notNull(),
            'telephone' => $this->integer(9)->unique(),
        ], $tableOptions);

        $this->addForeignKey('FK_id_user_pessoa', 'pessoa', 'id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('ticket', [
            'id' => $this->primaryKey(),
            'id_pessoa' => $this->integer()->notNull(),
            'data_de_compra' => $this->date()->notNull(),
            'data_de_uso' => $this->date()->notNull(),
            'preco' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_id_pessoa_ticket', 'ticket', 'id_pessoa', 'pessoa', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}

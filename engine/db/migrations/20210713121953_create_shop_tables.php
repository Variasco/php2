<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateShopTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        //удалим таблицы, если они существуют
        if ($this->hasTable('category')) {
            if ($this->hasTable('products')) {
                if ($this->hasTable('cart')) {
                    $this->table('cart')->drop()->save();
                }
                $this->table('products')->drop()->save();
            }
            $this->table('category')->drop()->save();
        }

        if ($this->hasTable('users'))
            $this->table('users')->drop()->save();

        if ($this->hasTable('orders'))
            $this->table('orders')->drop()->save();

        //структура таблицы category
        $this->table('category', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addIndex('name', ['unique' => true])
            ->create();

        //структура таблицы products
        $this->table('products', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('price', 'decimal', ['precision' => 11, 'scale' => 2])
            ->addColumn('description', 'text')
            ->addColumn('picture', 'string', ['limit' => 255])
            ->addColumn('category_id', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey('category_id', 'category', 'id', ['delete'=> 'SET_NULL', 'update'=> 'CASCADE'])
            ->addIndex(['name', 'category_id'], ['unique' => true])
            ->create();

        //структура таблицы cart
        $this->table('cart', ['signed' => false])
            ->addColumn('product_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('quantity', 'integer', ['signed' => false, 'default' => 1])
            ->addColumn('session_id', 'string', ['limit' => 255])
            ->addForeignKey('product_id', 'products', 'id', ['delete'=> 'SET_NULL', 'update'=> 'CASCADE'])
            ->addIndex(['session_id', 'product_id'])
            ->create();

        //структура таблицы users
        $this->table('users', ['signed' => false])
            ->addColumn('login', 'string', ['limit' => 255])
            ->addColumn('hash_pass', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('is_admin', 'boolean', ['default' => true])
            ->addColumn('hash_cookie', 'string', ['limit' => 255, 'null' => true])
            ->addIndex(['login', 'hash_cookie'], ['unique' => true])
            ->create();

        //структура таблицы orders
        $this->table('orders', ['signed' => false])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('phone', 'string', ['limit' => 255])
            ->addColumn('status', 'enum', ['values' => ['оформлен','обработан','отправлен','доставлен'], 'default' => 'оформлен'])
            ->addColumn('session_id', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex('session_id', ['unique' => true])
            ->addIndex('name')
            ->create();
    }
}

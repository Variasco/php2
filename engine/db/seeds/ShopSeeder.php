<?php


use Phinx\Seed\AbstractSeed;

class ShopSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $sql = "SET FOREIGN_KEY_CHECKS = 0; TRUNCATE `cart`; SET FOREIGN_KEY_CHECKS = 1";
        $this->adapter->query($sql);

        $sql = "SET FOREIGN_KEY_CHECKS = 0; TRUNCATE `products`; SET FOREIGN_KEY_CHECKS = 1";
        $this->adapter->query($sql);

        $sql = "SET FOREIGN_KEY_CHECKS = 0; TRUNCATE `category`; SET FOREIGN_KEY_CHECKS = 1";
        $this->adapter->query($sql);

        $sql = "SET FOREIGN_KEY_CHECKS = 0; TRUNCATE `users`; SET FOREIGN_KEY_CHECKS = 1";
        $this->adapter->query($sql);

        $sql = "SET FOREIGN_KEY_CHECKS = 0; TRUNCATE `orders`; SET FOREIGN_KEY_CHECKS = 1";
        $this->adapter->query($sql);

        $categories = [
            [
                'name' => 'Видеокарты'
            ]
        ];
        $products = [
            [
                'name' => 'Palit GeForce GTX 1050 Ti STORMX',
                'price' => '19799.00',
                'description' => 'PCI-E 3.0, 4 ГБ GDDR5, 128 бит, 1290 МГц - 1392 МГц, HDMI, DisplayPort, DVI-D',
                'picture' => 'Palit_1050ti.jpg',
                'category_id' => '1',
            ],
            [
                'name' => 'GIGABYTE GeForce GTX 1650 D6 OC',
                'price' => '26999.00',
                'description' => 'PCI-E 3.0, 4 ГБ GDDR6, 128 бит, 1410 МГц - 1635 МГц, DVI-D, DisplayPort, HDMI',
                'picture' => 'GIGABYTE_GTX_1650.jpg',
                'category_id' => '1',
            ],
            [
                'name' => 'ASRock AMD Radeon RX 5500 XT Challenger D OC',
                'price' => '56999.00',
                'description' => 'PCI-E 4.0, 8 ГБ GDDR6, 128 бит, 1685 МГц - 1845 МГц, DisplayPort (3 шт), HDMI',
                'picture' => 'ASRock_RX_5500XT.jpg',
                'category_id' => '1',
            ],
            [
                'name' => 'Palit GeForce RTX 2060 Dual',
                'price' => '58999.00',
                'description' => 'PCI-E 3.0, 6 ГБ GDDR6, 192 бит, 1365 МГц - 1680 МГц, DVI-D, DisplayPort, HDMI',
                'picture' => 'Palit_RTX_2060.jpg',
                'category_id' => '1',
            ],
            [
                'name' => 'GIGABYTE GeForce RTX 3060 GAMING OC (LHR)',
                'price' => '75999.00',
                'description' => 'PCI-E 4.0, 12 ГБ GDDR6, 192 бит, 1320 МГц, DisplayPort (2 шт), HDMI (2 шт)',
                'picture' => 'GIGABYTE_RTX_3060.jpg',
                'category_id' => '1',
            ],
            [
                'name' => 'GIGABYTE AORUS GeForce RTX 3070 MASTER',
                'price' => '121999.00',
                'description' => 'PCI-E 4.0, 8 ГБ GDDR6, 256 бит, 1500 МГц - 1845 МГц, DisplayPort (3 шт), HDMI (3 шт)',
                'picture' => 'GIGABYTE_RTX_3070.jpg',
                'category_id' => '1',
            ],
        ];
        $users = [
            [
                'login' => 'admin',
                'hash_pass' => '$2y$10$11xacmJ4Gz1c0D172YH2cuLhPDVmxN4H/QDbe1E0kl4aSEJrY2ue.',
                'is_admin' => '1',
                'hash_cookie' => null,
            ]
        ];

        $cart = [
            [
                'product_id' => '1',
                'quantity' => '2',
                'session_id' => 'tl6kfcnh4u8de222tk8u0lck0n59udap'
            ]
        ];

        $orders = [
            [
                'name' => 'admin',
                'phone' => 'телефон',
                'status' => 'оформлен',
                'session_id' => 'tl6kfcnh4u8de222tk8u0lck0n59udap'
            ]
        ];

        $this->table('category')->insert($categories)->save();
        $this->table('products')->insert($products)->save();
        $this->table('users')->insert($users)->save();
        $this->table('cart')->insert($cart)->save();
        $this->table('orders')->insert($orders)->save();
    }
}

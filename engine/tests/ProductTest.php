<?php


namespace app\tests;


use app\models\entities\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    protected $fixture;

    protected function setUp(): void
    {
        $this->fixture = new Product();
    }

    protected function tearDown(): void
    {
        $this->fixture = null;
    }

    public function testPropsAttribute()
    {
        $this->assertClassHasAttribute("props", Product::class);
        $this->assertIsArray($this->fixture->props);
    }

    /**
     * @dataProvider providerKeys
     */
    public function testPropsAttributeKeys($key)
    {
        $this->assertArrayHasKey($key, $this->fixture->props);
        $this->assertArrayHasKey('updated', $this->fixture->props[$key]);
        $this->assertArrayHasKey('value', $this->fixture->props[$key]);
    }

    /**
     * @dataProvider providerNull
     */
    public function testEmptyAttributes($value, $key)
    {
        $this->assertEquals($value, $this->fixture->$key);
    }

    /**
     * @dataProvider providerConstruct
     */
    public function testConstruct($name, $description, $price, $picture, $category_id)
    {
        $product = new Product($name, $description, $price, $picture, $category_id);
        $this->assertEquals($name, $product->name);
        $this->assertEquals($description, $product->description);
        $this->assertEquals($price, $product->price);
        $this->assertEquals($picture, $product->picture);
        $this->assertEquals($category_id, $product->category_id);
    }

    /**
     * @dataProvider providerNamespace
     */
    public function testNamespace($folder, $key)
    {
        $namespace = Product::class; // app\models\entities\Product
        $array = explode('\\', $namespace); // ['app', 'models', 'entities', 'Product']
        $this->assertCount(4, $array);
        $this->assertEquals($folder, $array[$key]);
    }

    public function providerNull()
    {
        return [
            [null, "id"],
            [null, "name"],
            [null, "price"],
            [null, "description"],
            [null, "picture"],
            [null, "category_id"],
        ];
    }

    public function providerKeys()
    {
        return [
            ["id"],
            ["name"],
            ["price"],
            ["description"],
            ["picture"],
            ["category_id"],
        ];
    }

    public function providerConstruct()
    {
        return [
            ['Чай', 'Описание чая', 150, null, null],
            ['Чай2', 'Описание чая2', '300', null, null],
        ];
    }

    public function providerNamespace()
    {
        return [
            ['app', 0],
            ['models', 1],
            ['entities', 2],
            ['Product', 3],
        ];
    }
}

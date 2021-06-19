<?php

class DefaultUnit
{
    public string $name;

    //Базовые атрибуты, вкачиваются при инициализации персонажа
    //Всего доступно 100 поинтов
    public int $strength;           //сила
    public int $intelligence;       //интеллект
    public int $agility;            //ловкость
    public int $health;             //здоровье
    //Все атрибуты могут варьироваться от 1 до 20. По умолчанию 10.
    //Стоимость увеличения силы и здоровья на единицу - 10 поинтов. Интеллекта и ловкости - 20
    //Можно как увеличивать атрибуты, вкладывая поинты, так и наоборот, забирая их

    //Второстепенные характеристики
    public int $hits;               //очки здоровья, основываются на силе ($hits = $strength*10, к примеру)
    public int $will;               //воля, основывается на интеллекте
    public int $perception;         //восприятие, основывается на ловкости
    public int $fatigue;            //усталость, основывается на здоровье

    public function __construct($name, $strength = 10, $intelligence = 10, $agility = 10, $health = 10)
    {
        $this->name = $name;

        $this->strength = $strength;
        $this->intelligence = $intelligence;
        $this->agility = $agility;
        $this->health = $health;

        $this->hits = $strength * 10;
        $this->will = $intelligence * 10;
        $this->perception = $agility * 10;
        $this->fatigue = $health * 10;
    }
}

class Warrior extends DefaultUnit
{
    public function attack(DefaultUnit $target)
    {
        $target->hits -= $this->agility + $this->strength;
        $this->fatigue -= 5;        //дебаф может также зависеть от характеристик, но мне лень
        echo "{$this->name} наносит простой удар по цели {$target->name}. Урон:" . $this->agility + $this->strength . "<br>";
    }

    public function attackHeavy(DefaultUnit $target)
    {
        $target->hits -= $this->agility + $this->strength * 2;
        $this->fatigue -= 20;
        echo "{$this->name} наносит тяжелый удар по цели {$target->name}. Урон:" . $this->agility + $this->strength * 2 . "<br>";
    }

    public function ultimate(DefaultUnit $target)
    {
        $target->hits -= ($this->agility + $this->strength) * 3;
        $this->fatigue -= 20;
        $this->will -= 60;
        echo "{$this->name} наносит сокрушающий удар по цели {$target->name}. Урон:" . ($this->agility + $this->strength) * 3 . "<br>";
    }


}

$dummy = new DefaultUnit("манекен");
$solder = new Warrior("Ронни", 14, 8, 12, 16);

$solder->attack($dummy);
$solder->attackHeavy($dummy);
$solder->ultimate($dummy);

//Очевидно, "хиты" манекена ушли в отрицательную зону
echo $dummy->hits;
//Вопрос. Куда и как прикручивать подобные проверки? Вопрос актуален и для усталости.
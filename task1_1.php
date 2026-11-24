<?php

class Vehicle {
    protected string $brand;
    protected int $maxSpeed;

    public function __construct(string $brand, int $maxSpeed) {
        $this->brand = $brand;
        $this->maxSpeed = $maxSpeed;
    }

    public function getInfo(): string {
        return "Марка: {$this->brand}, макс. скорость: {$this->maxSpeed} км/ч";
    }
}

class Car extends Vehicle {
    private string $fuelType;

    public function __construct(string $brand, int $maxSpeed, string $fuelType) {
        parent::__construct($brand, $maxSpeed);
        $this->fuelType = $fuelType;
    }

    public function getInfo(): string {
        return parent::getInfo() . ", топливо: {$this->fuelType}";
    }
}

class Airplane extends Vehicle {
    private float $wingspan;

    public function __construct(string $brand, int $maxSpeed, float $wingspan) {
        parent::__construct($brand, $maxSpeed);
        $this->wingspan = $wingspan;
    }

    public function getInfo(): string {
        return parent::getInfo() . ", размах крыльев: {$this->wingspan} м";
    }
}

$vehicles = [
    new Car("Toyota", 200, "бензин"),
    new Airplane("Boeing", 900, 60.0),
];

foreach ($vehicles as $v) {
    echo $v->getInfo() . "\n";
    echo "Это Vehicle? " . ($v instanceof Vehicle ? "да" : "нет") . "\n";
}
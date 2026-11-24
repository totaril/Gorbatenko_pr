<?php

abstract class Employee {
    protected string $name;
    protected float $baseSalary;

    public function __construct(string $name, float $baseSalary) {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
    }

    abstract public function calculateSalary(): float;

    public function getName(): string {
        return $this->name;
    }
}
// Employee нельзя создать напрямую, потому что он абстрактный (просто шаблон для наследников)

class Manager extends Employee {
    public function calculateSalary(): float {
        return $this->baseSalary * 1.2; // оклад + 20% премии
    }
}

class Developer extends Employee {
    private int $overtimeHours = 0;

    public function setOvertimeHours(int $hours): void {
        $this->overtimeHours = $hours;
    }

    public function calculateSalary(): float {
        return $this->baseSalary + $this->overtimeHours * 500;
    }
}

class Intern extends Employee {
    public function calculateSalary(): float {
        return $this->baseSalary * 0.5; // половина оклада
    }
}

function printPayroll(array $employees): void {
    $total = 0;
    echo "Имя — Зарплата\n";
    echo "----------------\n";
    foreach ($employees as $e) {
        $salary = $e->calculateSalary();
        echo $e->getName() . " — " . $salary . " руб.\n";
        $total += $salary;
    }
    echo "----------------\n";
    echo "Общий фонд: $total руб.\n";
}

$staff = [
    new Manager("Иван", 80000),
    new Developer("Пётр", 100000),
    new Intern("Саша", 40000),
];

$staff[1]->setOvertimeHours(10);

printPayroll($staff);
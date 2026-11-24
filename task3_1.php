<?php

trait LoggerTrait {
    protected array $logs = [];

    public function log(string $message): void {
        $this->logs[] = "[" . date('Y-m-d H:i:s') . "] $message";
    }

    public function getLogs(): array {
        return $this->logs;
    }

    public function clearLogs(): void {
        $this->logs = [];
    }
}
// трейт тут удобнее наследования, потому что UserService и OrderService никак не связаны а трейт позволяет просто "вшить" им логирование без общей базы

class UserService {
    use LoggerTrait;

    public function register(string $username): void {
        $this->log("Зарегистрирован пользователь: $username");
    }
}

class OrderService {
    use LoggerTrait;

    public function createOrder(int $orderId, float $total): void {
        $this->log("Создан заказ #$orderId на сумму $total руб.");
    }
}

$users = new UserService();
$orders = new OrderService();

$users->register("Вовчик");
$users->register("Никита");
$orders->createOrder(101, 1500.50);
$orders->createOrder(102, 3200.00);

echo "Логи UserService:\n";
print_r($users->getLogs());

echo "Логи OrderService:\n";
print_r($orders->getLogs());

$users->clearLogs();
echo "После очистки UserService:\n";
print_r($users->getLogs());
echo "OrderService не тронут:\n";
print_r($orders->getLogs());
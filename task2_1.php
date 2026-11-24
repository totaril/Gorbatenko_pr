<?php

interface PaymentInterface {
    public function pay(float $amount): bool;
    public function refund(float $amount): bool;
    public function getMethodName(): string;
}

class CreditCard implements PaymentInterface {
    private float $limit;

    public function __construct(float $limit) {
        $this->limit = $limit;
    }

    public function pay(float $amount): bool {
        return $amount <= $this->limit;
    }

    public function refund(float $amount): bool {
        return true;
    }

    public function getMethodName(): string {
        return "Кредитная карта";
    }
}

class PayPal implements PaymentInterface {
    private float $balance;

    public function __construct(float $balance) {
        $this->balance = $balance;
    }

    public function pay(float $amount): bool {
        if ($amount > $this->balance) return false;
        $this->balance -= $amount;
        return true;
    }

    public function refund(float $amount): bool {
        $this->balance += $amount;
        return true;
    }

    public function getMethodName(): string {
        return "PayPal";
    }
}

class Cash implements PaymentInterface {
    public function pay(float $amount): bool {
        return true;
    }

    public function refund(float $amount): bool {
        return true;
    }

    public function getMethodName(): string {
        return "Наличные";
    }
}

function checkout(PaymentInterface $method, float $amount): void {
    $result = $method->pay($amount) ? "успешно" : "отказ";
    echo "{$method->getMethodName()}: оплата $amount руб. — $result\n";
}

checkout(new CreditCard(5000), 3000);
checkout(new CreditCard(5000), 6000);
checkout(new PayPal(1000), 500);
checkout(new PayPal(1000), 2000);
checkout(new Cash(), 9999);
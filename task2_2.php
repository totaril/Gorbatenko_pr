<?php

interface ReportFormatterInterface {
    public function format(array $data): string;
}

interface ReportHeaderInterface {
    public const SEPARATOR = "====================";
    public function getHeader(): string;
}

class HtmlFormatter implements ReportFormatterInterface {
    public function format(array $data): string {
        $items = "";
        foreach ($data as $item) {
            $items .= "<li>$item</li>";
        }
        return "<ul>$items</ul>";
    }
}

class CsvFormatter implements ReportFormatterInterface {
    public function format(array $data): string {
        return implode(";", $data);
    }
}

class SalesReport implements ReportFormatterInterface, ReportHeaderInterface {
    private array $sales;

    public function __construct(array $sales) {
        $this->sales = $sales;
    }

    public function getHeader(): string {
        return "Отчёт о продажах за текущий период";
    }

    public function format(array $data): string {
        $out = "";
        foreach ($this->sales as $product => $sum) {
            $out .= "Продукт: $product — сумма: $sum руб.\n";
        }
        return $out;
    }
}

function renderReport(ReportFormatterInterface $report): void {
    echo $report->format([]);
}

$report = new SalesReport(["Хлеб" => 100, "Молоко" => 80, "Сыр" => 300]);

echo ReportHeaderInterface::SEPARATOR . "\n";
echo $report->getHeader() . "\n";
echo ReportHeaderInterface::SEPARATOR . "\n";
renderReport($report);
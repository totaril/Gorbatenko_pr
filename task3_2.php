<?php

trait JsonExportTrait {
    public function export(): string {
        $data = [];
        foreach (get_object_vars($this) as $k => $v) {
            $data[$k] = $v;
        }
        return json_encode($data);
    }

    public function getFormat(): string {
        return "JSON";
    }
}

trait XmlExportTrait {
    public function export(): string {
        $xml = "<product>";
        foreach (get_object_vars($this) as $k => $v) {
            $xml .= "<$k>$v</$k>";
        }
        $xml .= "</product>";
        return $xml;
    }

    public function getFormat(): string {
        return "XML";
    }
}

trait PriceTrait {
    public function getPriceWithTax(float $tax): float {
        return $this->price * (1 + $tax / 100);
    }
}

class Product {
    use JsonExportTrait, XmlExportTrait, PriceTrait {
        JsonExportTrait::export insteadof XmlExportTrait;
        XmlExportTrait::export as exportToXml;
        JsonExportTrait::getFormat insteadof XmlExportTrait;
        XmlExportTrait::getFormat as getXmlFormat;
    }

    public string $name;
    public float $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
    }

    // если раскомментировать этот метод - он будет вызываться вместо трейтов, потому что метод самого класса имеет наивысший приоритет
    // public function getFormat(): string { return "Product format"; }
}

$p = new Product("Ноутбук", 50000);

echo "JSON: " . $p->export() . "\n";
echo "XML:  " . $p->exportToXml() . "\n";
echo "Формат (основной): " . $p->getFormat() . "\n";
echo "Формат (XML): " . $p->getXmlFormat() . "\n";
echo "Цена с налогом 20%: " . $p->getPriceWithTax(20) . "\n";
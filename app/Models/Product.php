<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Exception;

class ProductFactory {

    private function __construct()
    {
        
    }
}

class Product extends Model
{
    //
    protected $fillable = ['description', 'cost', 'margin', 'applies_margin', 'fixed_price', 'calculated_price', 'category_id', 'brand_id'];
    protected $privateSet = ['calculated_price'];

    public function __set($key, $value) {
        if ($this->isPrivateSet($key))
            throw new Exception("Cannot set $key because it's private");

        if ($this->attributeExists($key)) {
            switch($key) {
                case 'cost':
                    $this->setCost($value);
                    break;
                case 'margin':
                    $this->setMargin($value);
                    break;
                case 'fixed_price':
                    $this->setFixedPrice($value);
                    break;
                case 'applies_margin':
                case 'description':
                case 'category_id':
                case 'brand_id':
                    $this->attributes[$key] = $value;
                    break;
            }
        }
        
        $this->attributes[$key] = $value;
    }

    public function attributeExists($key): bool {
        return in_array($key, $this->fillable);
    }

    public function isPrivateSet($key): bool {
        return in_array($key, $this->privateSet);
    }

    private function updateCalculatedPrice(): void
    {
        $this->attributes['calculated_price'] = (1 + $this->margin / 100) * $this->cost;
    }

    private function setCost(float $value): void
    {
        if ($value < 0)
            throw new Exception('Cost cannot be negative!');
        $this->attributes['cost'] = $value;
        $this->updateCalculatedPrice();
    }

    private function setMargin(float $value): void
    {
        if ($value < 0)
            throw new Exception('Margin cannot be negative');
        if ($value > 200)
            throw new Exception('Margin cannot be greater than 200%');
        $this->attributes['margin'] = $value;
        $this->updateCalculatedPrice();
    }

    private function setFixedPrice(float $value): void
    {
        if ($value < 0)
            throw new Exception('Fixed price cannot be negative');
        $this->attributes['fixed_price'] = $value;
    }

    /**
     * @return float
     */
    public function getPriceAttribute() {
        return $this->applies_margin ? $this->calculated_price : $this->fixed_price;
    }
}

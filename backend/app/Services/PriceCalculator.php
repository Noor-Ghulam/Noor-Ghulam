<?php

namespace App\Services;

class PriceCalculator
{
    public function calculate(array $config, array $selection): array
    {
        $baseCost = 0.0;
        $products = $config['products'] ?? [];

        foreach ($selection as $productKey => $features) {
            if (!isset($products[$productKey])) {
                continue;
            }

            foreach ($products[$productKey]['features'] as $feature) {
                $featureId = $feature['id'];
                $value = $features[$featureId] ?? null;
                $baseCost += $this->featureCost($feature, $value);
            }
        }

        $overheads = $baseCost * ($config['overheads_pct'] ?? 0);
        $subtotal = $baseCost + $overheads;

        $tiers = [];
        foreach ($config['margin_tiers'] ?? [] as $tier => $margin) {
            $tiers[$tier] = [
                'margin_pct' => $margin,
                'price' => $subtotal * (1 + $margin),
            ];
        }

        return [
            'currency' => $config['currency'] ?? 'USD',
            'base_cost' => $baseCost,
            'overheads' => $overheads,
            'subtotal' => $subtotal,
            'tiers' => $tiers,
        ];
    }

    private function featureCost(array $feature, mixed $value): float
    {
        $pricing = $feature['pricing'] ?? 'per_unit';
        $unitPrice = (float) ($feature['unit_price'] ?? 0);

        if ($pricing === 'flat') {
            return $value ? $unitPrice : 0.0;
        }

        $numericValue = is_numeric($value) ? (float) $value : 0.0;
        return $numericValue * $unitPrice;
    }
}

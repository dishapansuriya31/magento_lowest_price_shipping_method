<?php
namespace Kitchen\NewShipping\Plugin;

use Magento\Quote\Model\Quote\Address\RateResult\Method;

class FilterShippingMethod
{
    public function afterCollectRates(
        \Magento\Shipping\Model\Shipping $subject,
        \Magento\Shipping\Model\Shipping $result
    ) {
        $rateResult = $result->getResult();
        $allRates = $rateResult->getAllRates();

        if (count($allRates) > 1) {
            $lowestRate = null;
            $lowestPrice = PHP_INT_MAX;

            foreach ($allRates as $rate) {
                if ($rate->getPrice() < $lowestPrice) {
                    $lowestPrice = $rate->getPrice();
                    $lowestRate = $rate;
                }
            }

            if ($lowestRate) {
                $rateResult->reset();
                $rateResult->append($lowestRate);
            }
        }

        return $result;
    }
}

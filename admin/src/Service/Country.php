<?php
namespace App\Service;

use Symfony\Component\Intl\Intl;

class Country
{
    public function getCountry($countryCode)
    {
        $country = Intl::getRegionBundle()->getCountryName($countryCode);
        return $country;
    }
}
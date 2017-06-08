<?php namespace App\Libraries\GeoService;

interface GeoServiceInterface
{
    /**
     * Get lat long of given postcode
     *
     * @return array
     */
    public function getLatLong();

    /**
     * Get nearby of given postcode
     *
     * @return array
     */
    public function getNearby();
}

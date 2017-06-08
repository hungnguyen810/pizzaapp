<?php namespace App\Libraries\GeoService;

use GuzzleHttp\Client;

class GeoService implements GeoServiceInterface
{
    protected $address;
    protected $postcode;
    protected $radius;

    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get nearby postcodes using Google places API
     *
     * @return array
     */
    private function _gooleNearby()
    {

        $latLong = $this->getLatLong();

        $query = $this->httpClient->get(env('NEARBY_URL'), [
            'query' => [
                'key'      => env('GOOGLE_API_KEY'),
                'types'    => 'real_estate_agency,lodging,establishment',
                'location' => implode(',', $latLong),
                'radius'   => 5000,
                //'radius-in-meters-max-50-000-meters',
            ],
        ]);
        $response = json_decode($query->getBody()->getContents());
        $result = [];
        foreach ($response->results as $item) {
            $result[] = $item;
        }

        while (!empty($response->next_page_token)) {

            sleep(2); // Google forced us to wait before calling next request

            $query = $this->httpClient->get(env('NEARBY_URL'), [
                'query' => [
                    'key'       => env('GOOGLE_API_KEY'),
                    'pagetoken' => $response->next_page_token,
                ],
            ]);

            $response = json_decode($query->getBody()->getContents());

            foreach ($response->results as $item) {
                $result[] = $item;
            }
        }

        return $result;

    }

    /**
     * Get lat long using Google API
     *
     * @return array
     */
    private function _googleLatLong()
    {
        $query = $this->httpClient->get(env('GEOCODE_URL'), [
            'query' => [
                'address' => $this->postcode,
                'sensor'  => 'false'
            ]
        ]);

        $response = json_decode($query->getBody()->getContents());

        return (array) $response->results[0]->geometry->location;
    }

    /**
     * Set this postcode
     *
     * @param $postcode
     *
     * @return $this
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Set this radius
     *
     * @param $radius
     *
     * @return $this
     */
    public function setRadius($radius)
    {
        $this->radius = $radius * 1.60934 * 1000;

        return $this;
    }

    /**
     * Get lat long of given postcode
     *
     * @return array
     */
    public function getLatLong()
    {
        return $this->_googleLatLong();
    }

    /**
     * Get nearby of given postcode
     *
     * @return array
     */
    public function getNearby()
    {
        return $this->_gooleNearby();
    }
}

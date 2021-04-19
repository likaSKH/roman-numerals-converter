<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RomanNumeralEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test top 10 converted integers endpoint.
     *
     * @return void
     */
    public function testTopConvertedIntegersEndpoint()
    {
        $this->seed();

        // Get response from endpoint
        $response = $this->json('Get', '/api/top_converted_integers');

        // Check that length of returned data is 10 or less (for the cases if there is no 10 records);
        $this->assertLessThanOrEqual(10, sizeof($response->getData()->data));
    }

    /**
     * Test recently converted integers endpoint.
     *
     * @return void
     */
    public function testRecentlyConvertedIntegersEndpoint()
    {
        $this->seed();

        // Get response from endpoint
        $response = $this->json('Get', '/api/recently_converted_integers');

        // Check that returned data is ordered with created date descending.
        $this->assertTrue($this->checkOrder($response->getData()->data));
    }

    /**
     * Return true if array is ordered DESC.
     *
     * @param $array
     * @return bool
     */
    public function checkOrder($array): bool
    {
        $i = 0;
        $sizeOfArray = sizeof($array);

        while($sizeOfArray > 1)
        {
            if($array[$i]->created_at > $array[$i+1]->created_at) {
                $i++;
                $sizeOfArray--;
            } else {
                return false;
            }
        }

        return true;
    }
}

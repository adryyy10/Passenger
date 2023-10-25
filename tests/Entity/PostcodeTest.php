<?php

namespace App\Tests\Entity;

use App\Controller\Postcode\GetController;
use App\Controller\Postcode\GetNearPostcodeController;
use App\Interface\PostcodeSearchInterface;
use App\Interface\PostcodeSearchNearbyInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PostcodeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFindPostcodesByPartialName(): void
    {
        $postCodeSearchInterface = $this->createMock(PostcodeSearchInterface::class);

        // Create an instance of GetController, passing the mock as a dependency.
        $controller = new GetController($postCodeSearchInterface);

        // Create a mock Request object with the required query parameter.
        $request = Request::create('/postcodes', 'GET', ['postcode' => 'EJ']);

        // Call the controller action method.
        $response = $controller->getPartialPostcodesAction($request);

        // Check the response content and status code.
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertNotNull($response->getContent());
    }

    public function testFindNearbyPostcodesBadRequest(): void
    {
        $postCodeSearchNearbyInterface = $this->createMock(PostcodeSearchNearbyInterface::class);

        // Create an instance of GetController, passing the mock as a dependency.
        $controller = new GetNearPostcodeController($postCodeSearchNearbyInterface);

        // Create a mock Request object with the required query parameter.
        $request = Request::create('/nearby-postcodes', 'GET', [
            'latitude' => '57.14855',
            'longitude' => ' -2.28882',
            'distance' => null
        ]);

        // Call the controller action method.
        $response = $controller->getPartialPostcodesAction($request);

        // Check the response content and status code.
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testFindNearbyPostcodes(): void
    {
        $postCodeSearchNearbyInterface = $this->createMock(PostcodeSearchNearbyInterface::class);

        $controller = new GetNearPostcodeController($postCodeSearchNearbyInterface);

        $request = Request::create('/nearby-postcodes', 'GET', [
            'latitude' => '57.14855',
            'longitude' => ' -2.28882',
            'distance' => 20
        ]);

        $response = $controller->getPartialPostcodesAction($request);

        // Check the response content and status code.
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertNotNull($response->getContent());
    }
}

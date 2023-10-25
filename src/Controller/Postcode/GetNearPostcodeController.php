<?php

namespace App\Controller\Postcode;

use App\Interface\PostcodeSearchNearbyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetNearPostcodeController extends AbstractController
{
    public function __construct(
        private readonly PostcodeSearchNearbyInterface $postcodeSearchNearbyRepository
    ){}

    #[Route('/nearby-postcodes', name: 'app_get_nearby_postcodes')]
    public function getPartialPostcodesAction(Request $request): JsonResponse
    {
        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');
        $distance = $request->query->get('distance');

        if (
            empty($latitude) ||
            empty($longitude) ||
            empty($distance)
        ) {
            return new JsonResponse(
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'distance' => $distance,
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $postcodes = $this->postcodeSearchNearbyRepository->findNearbyPostcodes($latitude, $longitude, $distance);

        return new JsonResponse(
            [
                'postcodes' => $postcodes,
            ],
            Response::HTTP_OK
        );
    } 
}

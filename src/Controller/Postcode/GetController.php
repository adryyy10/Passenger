<?php

namespace App\Controller\Postcode;

use App\Interface\PostcodeSearchInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetController extends AbstractController 
{
    public function __construct(
        private readonly PostcodeSearchInterface $postcodeSearchRepository
    ){}

    #[Route('/postcodes', name: 'app_get_postcodes')]
    public function getPartialPostcodesAction(Request $request): JsonResponse
    {
        $postcodeName = $request->query->get('postcode');

        $postcodes = (empty($postcodeName)) 
                        ? $this->postcodeSearchRepository->findAll() 
                        : $this->postcodeSearchRepository->findByPartialString($postcodeName);

        return new JsonResponse(
            [
                'postcodes' => $postcodes,
            ],
            Response::HTTP_OK
        );
    } 
}

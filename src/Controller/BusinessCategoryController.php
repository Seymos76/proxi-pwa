<?php


namespace App\Controller;


use App\Repository\BusinessCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class BusinessCategoryController
 * @package App\Controller
 * @Route(path="/api")
 */
class BusinessCategoryController extends AbstractController
{
    /**
     * @Route(path="/business-categories", name="api_business_categories")
     * @return JsonResponse
     */
    public function businessCategories(
        BusinessCategoryRepository $businessCategoryRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $businessCategories = $businessCategoryRepository->findAll();
        $jsonData = $serializer->serialize($businessCategories, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['business']]);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
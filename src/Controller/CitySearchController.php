<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CitySearchController
 * @package App\Controller
 * @Route(path="/api")
 */
class CitySearchController extends AbstractController
{
    /**
     * @Route(path="/cities", name="api_cities")
     * @return JsonResponse
     */
    public function searchCity(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
    )
    {
        if ($request->query->count() < 1) {
            $jsonData = "Votre recherche ne peut aboutir à moins de fournir un élément de recherche";
            return new JsonResponse($jsonData, Response::HTTP_NOT_FOUND, [], true);
        }
        if($request->query->get('search') === null) {
            $jsonData = "Votre recherche ne peut aboutir à moins de fournir un élément de recherche";
            return new JsonResponse($jsonData, Response::HTTP_NOT_FOUND, [], true);
        }
        $search = $request->query->get('search');
        $cities = [];
        if (preg_match('/^\d{5,9}$/', $search)) {
            $query = $entityManager->createQuery('SELECT DISTINCT c.name, c.zipCode, c.id, c.slug FROM App\Entity\City c WHERE c.zipCode like ?1');
            $query->setParameter(1,"$search%");
            $cities = $query->getResult();
        } else {
            $query = $entityManager->createQuery('SELECT DISTINCT c.name, c.zipCode, c.id, c.slug FROM App\Entity\City c WHERE c.slug like ?1');
            $query->setParameter(1,"$search%");
            $cities = $query->getResult();
        }

        if (count($cities) === 0) {
            $jsonData = "Aucun résultat pour cette recherche...";
            return new JsonResponse($jsonData, Response::HTTP_NOT_FOUND, [], true);
        }
        $jsonData = $serializer->serialize($cities, 'json', ['city_search']);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
}
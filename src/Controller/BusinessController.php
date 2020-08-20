<?php


namespace App\Controller;


use App\Entity\Business;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class BusinessController
 * @package App\Controller
 * @Route(path="/api")
 */
class BusinessController extends AbstractController
{
    /**
     * @Route(path="/business/by-city", name="search_businesses_from_city")
     * @return JsonResponse
     */
    public function searchAllBusinessesFromCity(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
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
        $businessList = [];
        if (preg_match('/^\d{5,9}$/', $search)) {
            $query = $entityManager->createQuery('SELECT DISTINCT b.name, b.address, b.id, b.slug FROM App\Entity\Business b JOIN b.city c WHERE c.zipCode = ?1');
            $query->setParameter(1,$search);
            $businessList = $query->getResult();
        } else {
            $query = $entityManager->createQuery('SELECT DISTINCT b.name, b.address, b.id, b.slug FROM App\Entity\Business b JOIN b.city c WHERE c.slug like ?1');
            $query->setParameter(1,"$search%");
            $businessList = $query->getResult();
        }

        $jsonData = $serializer->serialize($businessList, 'json', ['city_search']);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    /**
     * @Route(path="/business/by-slug", name="search_business_by_slug")
     * @return JsonResponse
     */
    public function businessBySlug(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
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
        $query = $entityManager->createQuery('SELECT DISTINCT b FROM App\Entity\Business b WHERE b.slug = ?1');
        $query->setParameter(1,$search);
        /** @var Business $business */
        $business = $query->getResult();
//        dd($business);

        $jsonData = $serializer->serialize($business, 'json', ['groups' => ['business_page']]);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    /**
     * @Route(path="/business/timetables", name="business_create_timetables")
     * @return Response
     */
    public function businessCreateTimeTable()
    {
        /** @example $time = strtotime('20-09-2020 21:00'); */
        $time = strtotime('20-09-2020 21:00');
        /** @example $date = date(string format, strtotime); */
        $date = date('d/m/Y H:i',strtotime('21:00'));
        $dateTime = \DateTime::createFromFormat('d/m/Y H:i',$date);
        dump($dateTime);
        $formatted = $dateTime->format('H:i');
        return new Response("Date: $formatted", 200);
    }
}
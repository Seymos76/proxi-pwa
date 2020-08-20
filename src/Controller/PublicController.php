<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;

class PublicController extends AbstractController
{
    /**
     * @Route(path="/", name="public_homepage")
     * @return Response
     */
    public function home()
    {
        return $this->render(
            'public/home.html.twig'
        );
    }

    /**
     * @Route(path="/landing", name="public_landing")
     * @return Response
     */
    public function landing()
    {
        return $this->render(
            'public/landing.html.twig'
        );
    }

    /**
     * @Route(path="/inscription-marchand", name="public_shopkeeper_register")
     * @return Response
     */
    public function registerAsShopKeeper()
    {
        return $this->render(
            'public/register_as_shopkeeper.html.twig'
        );
    }

    /**
     * @Route(path="/inscription-particulier", name="public_individual_register")
     * @return Response
     */
    public function registerAsIndividual()
    {
        return $this->render(
            'public/register_as_individual.html.twig'
        );
    }
}
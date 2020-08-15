<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route(path="/research", name="public_research")
     * @return Response
     */
    public function research()
    {
        return $this->render(
            'public/research.html.twig'
        );
    }
}
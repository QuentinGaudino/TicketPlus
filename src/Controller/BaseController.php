<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BaseController extends AbstractController
{
        /**
     * @Route("/check-user", name="check-user")
     */
    public function checkUser(): Response
    {
        if ($this->isGranted('ROLE_SUPPORT')){
            return $this->redirectToRoute('accueil-back');
        }
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('accueil-front');
        }

        return $this->render('base/erreurDroits.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/front-office", name="accueil-front")
     * @IsGranted("ROLE_USER")
     */
    public function accueilFront(): Response
    {
        return $this->render('base/accueilFront.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/back-office", name="accueil-back")
     * @IsGranted("ROLE_SUPPORT")
     */
    public function accueilBack(): Response
    {
        return $this->render('base/accueilBack.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
}

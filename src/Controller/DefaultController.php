<?php

namespace App\Controller;

use App\Entity\PDossier;
use App\Entity\UserAffectation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DefaultController extends AbstractController
{
    /**
     * @Route("/dossier", name="dossier")
     */
    public function index(): Response
    {
       
        // $this->getUser()->getId();
        $userId   = $this->getUser()->getId() ;
        $UserAffectation = $this->getDoctrine()->getRepository(UserAffectation::class)->findByuser($userId);
        
        return $this->render('default/index.html.twig', [
                'UserAffectation'=> $UserAffectation
        ]);
    }
}

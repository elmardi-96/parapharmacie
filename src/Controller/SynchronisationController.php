<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\VLivraisoncab;
use App\Entity\VLivraisondet;
use App\Entity\PDossier;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;




class SynchronisationController extends AbstractController
{
    /**
     * @Route("/synchroniser", name="synchroniser")
     */
    public function index(): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');
             
        return $this->render('synchronisation/index.html.twig', [
            'controller_name' => 'SynchronisationController',
        ]);
    }

    /**
     * @Route("/synchroniser_data", name="synchroniser_data")
     */
    public function synchroniser_data(): Response
    {
        if ($this->test())
            return $this->redirectToRoute('dossier');

        $session = new Session();
         
        $sel=" select cab.codelivraison,cab.datelivraison,cab.remise ,cab.mtremise,cab.dateremise,cab.id_dossier, det.idlivcab ,
               det.article , det.unite , det.quantite , det.prixunitaire , det.tva , det.prixttc , det.dateoperation , det.idlivdet
        from   t_livraisonfrscab as cab
        inner join t_livraisonfrsdet as det on det.idlivcab = cab.codelivraison
        where  id_dossier = " . $session->get('id_dossier_ugouv') . "" ;

        $stmt = $this->getDoctrine()->getConnection('ugouv')->prepare($sel);
        $stmt->execute();
        $empRecords = $stmt->fetchAll();

        $codeCab="";
        $VLivraisoncab = "";

        $entityManager = $this->getDoctrine()->getManager();

        foreach($empRecords as  $cab){

                if( $codeCab != $cab['codelivraison'] ){

                    $VLivraisoncabExist = $this->getDoctrine()->getRepository(VLivraisoncab::class) ->findOneByCodeLivraison($cab['codelivraison']);
                }
                

                if(!$VLivraisoncabExist ){
                    
                    if( $codeCab != $cab['codelivraison'] ){

                        $VLivraisoncab = new VLivraisoncab();

                        $PDossier = $this->getDoctrine()->getRepository(PDossier::class) ->findOneByIdUgouv($session->get('id_dossier_ugouv'));
                        $VLivraisoncab->setDossier($PDossier);
                        $VLivraisoncab->setUserCreate($this->getUser());

                        $VLivraisoncab->setCodeLivraison($cab['codelivraison']);
                        $DateLivraison = new \DateTime($cab['datelivraison']);
                        $VLivraisoncab->setDateLivraison($DateLivraison);
                        $VLivraisoncab->setRemise($cab['remise']);
                        $dateremise    = new \DateTime($cab['dateremise']);
                        $VLivraisoncab->setDateRemise($dateremise);
                        $VLivraisoncab->setMtRemise($cab['mtremise']);
                        $VLivraisoncab->setIdDossierUgouv($cab['id_dossier']);

                        $dNow        = new \DateTime(date("Y/m/d"));
                        $VLivraisoncab->setDateCreation($dNow);
                        
                        $entityManager->persist($VLivraisoncab);
                        $entityManager->flush();
        
                    }

                    $codeCab = $cab['codelivraison'];


                }

                $VLivraisondetExist = $this->getDoctrine()->getRepository(VLivraisondet::class) ->findByIdEgouv($cab['idlivdet']);

                if(!$VLivraisondetExist){

                    $VLivraisondet = new VLivraisondet();

                    //$VLivraisoncab->setdossierId($cab['id_dossier']);
                    if(!$VLivraisoncabExist){
                        $VLivraisondet->setLivraisoncab($VLivraisoncab);
                    }else{
                        $VLivraisondet->setLivraisoncab($VLivraisoncabExist);
                        
                    }
                    $dNow        = new \DateTime(date("Y/m/d"));
                    $VLivraisondet->setDateCreation($dNow);
                    $VLivraisondet->setArticle($cab['article']);
                    $VLivraisondet->setUnite($cab['unite']);
                    $VLivraisondet->setQuantite($cab['quantite']);
                    $VLivraisondet->setpriUnitaire($cab['prixunitaire']);
                    $VLivraisondet->setTva($cab['tva']);
                    $VLivraisondet->setPrixTtc($cab['prixttc']);
                    $dateoperation = new \DateTime($cab['dateoperation']);
                    $VLivraisondet->setdateOperation($cab['dateoperation']);
                    $VLivraisondet->setIdEgouv($cab['idlivdet']);
                    $VLivraisondet->setUserCreate($this->getUser());

                    
                    $entityManager->persist($VLivraisondet);
                    $entityManager->flush();

                }
            
        }
        



         return new JsonResponse('ok');
    }

    public function test()
    {
      $session = new Session();
      if(empty($session->get('id_dossier_local'))){
            return $dossier = true ;
      }
    } 

    
}

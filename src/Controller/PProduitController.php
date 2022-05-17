<?php

namespace App\Controller;

use App\Entity\PProduit;
use App\Entity\TStock;
use App\Entity\PArticle;
use App\Entity\PDossier;
use App\Entity\VLivraisondet;
use App\Form\PProduitType;
use App\Repository\PProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * @Route("/p/produit")
 */
class PProduitController extends AbstractController
{
    /**
     * @Route("/", name="p_produit_index", methods={"GET"})
     */
    public function index(PProduitRepository $pProduitRepository): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_produit/index.html.twig', [
            'p_produits' => $pProduitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="p_produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        // dd($request->request->get('id_det'));
        $pProduit = new PProduit();
        $form = $this->createForm(PProduitType::class, $pProduit);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {

            $session = new Session();

            $entityManager = $this->getDoctrine()->getManager();
            
            // ---- produit ----
            $dossier = $this->getDoctrine()->getRepository(PDossier::class) ->findOneById( $session->get('id_dossier_local'));
            $pProduit->setDossier($dossier);

            $article = $this->getDoctrine()->getRepository(PArticle::class) ->findOneById($request->request->get('article'));
            $pProduit->setArticle($article);
            $pProduit->setUserCreation($this->getUser());
            
            $VLivraisondet = $this->getDoctrine()->getRepository(VLivraisondet::class)->findOneById($request->request->get('id_det'));
            $pProduit->setLivraisondet($VLivraisondet);

            $dNow          = new \DateTime(date("Y/m/d"));
            $pProduit->setDateCreation($dNow);
            $dateExp       = new \DateTime($request->request->get('dateExp'));
            $pProduit->setDateExp($dateExp);

            $pProduit->setQteReste($request->request->get('p_produit')['qte']);

            $entityManager->persist($pProduit);

            // ---- livraison det ----
            $VLivraisondet->setEnStock(1);
            $entityManager->persist($VLivraisondet);

            // ---- stock ----

            $TStock = $this->getDoctrine()->getRepository(TStock::class)->findOneByArticle($request->request->get('article'));

            if($TStock){
                $qte= $TStock->getQuantite() + $request->request->get('p_produit')['qte'];
                $TStock->setQuantite($qte);
                $entityManager->persist($TStock);
            }else{
                
                $TStock = new TStock();

                $TStock->setArticle($article);
                $TStock->setDossier($dossier);
                $TStock->setQuantite($request->request->get('p_produit')['qte']);
                $dNow          = new \DateTime(date("Y/m/d"));
                $TStock->setDateCreation($dNow);
                $TStock->setUserCreate($this->getUser());
                
                $entityManager->persist($TStock);
            }
           
            $entityManager->flush();

            return new JsonResponse('ok');
        }else{

            foreach ($form->getErrors(true) as $error) {
                $ers[$error->getOrigin()->getName()] = $error->getMessage();
            }
            return new JsonResponse($ers);
        }
    }

    /**
     * @Route("/get_aticle", name="get_aticle")
     */
    public function get_aticle(Request $request): Response
    {
            if ($this->test())
                return $this->redirectToRoute('dossier');

            $PProduit = $this->getDoctrine()->getRepository(VLivraisondet::class) ->findOneById($request->request->get('id')); 
            
            $Produit['id_det']           = $PProduit->getId();
            $Produit['designation']      = $PProduit->getArticle();
            $Produit['prixAchat']        = $PProduit->getPriUnitaire();
            $Produit['quantite']         = $PProduit->getQuantite();
            $Produit['tva']              = $PProduit->getTva();
            
            return new JsonResponse($Produit);

    }

    // /**
    //  * @Route("/{id}", name="p_produit_show", methods={"GET"})
    //  */
    // public function show(PProduit $pProduit): Response
    // {
    //     return $this->render('p_produit/show.html.twig', [
    //         'p_produit' => $pProduit,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/edit", name="p_produit_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, PProduit $pProduit): Response
    // {
    //     $form = $this->createForm(PProduitType::class, $pProduit);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('p_produit_index');
    //     }

    //     return $this->render('p_produit/edit.html.twig', [
    //         'p_produit' => $pProduit,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="p_produit_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, PProduit $pProduit): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$pProduit->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($pProduit);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('p_produit_index');
    // }



    /**
     * @Route("/produit_data", name="produit_data")
     */
    public function produit_data(): Response
    {   
          if ($this->test())
            return $this->redirectToRoute('dossier');

          $session = new Session();

          ## Read value
          $draw = $_POST['draw'];
          $row = $_POST['start'];
          $rowperpage = $_POST['length']; // Rows display per page
          $columnIndex = $_POST['order'][0]['column']; // Column index
          $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
          $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
          $searchValue = $_POST['search']['value']; // Search value
          
  
          ## Search 
          $searchQuery = " ";
          if($searchValue != ''){
              $searchQuery = " and ( 
                                     designation        like '%".$searchValue."%'  or 
                                     prix_achat         like '%".$searchValue."%'  or 
                                     prix_vente         like '%".$searchValue."%'  or 
                                     n_lot              like '%".$searchValue."%'  or
                                     date_exp           like '%".$searchValue."%'  or
                                     code_barre         like '%".$searchValue."%'  or
                                     tva                like '%".$searchValue."%'  or
                                     conditionnement    like '%".$searchValue."%'  or
                                     code_zone          like '%".$searchValue."%'  or
                                     qte_reste          like '%".$searchValue."%' 
                                   )";
          }
          
          ## Total number of records without filtering
          $sel=" select count(*) as allcount from pproduit where dossier_id = " . $session->get('id_dossier_local')  ;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
        //   $stmt->execute();
          $pproduit=$stmt->executeQuery();
          $result = $pproduit->fetch();
          $totalRecords = $result['allcount'];

        //   dd($totalRecords);
  
  
          ## Total number of records with filtering
          $sel=" select count(*) as allcount from pproduit WHERE 1 and dossier_id = " . $session->get('id_dossier_local') .' '.$searchQuery;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $pproduit=$stmt->executeQuery();
          $result = $pproduit->fetch();
          $totalRecordwithFilter = $result['allcount'] ;
         
  
          ## Fetch records
          $sel="select * from pproduit WHERE 1 and dossier_id = " . $session->get('id_dossier_local') .' '.$searchQuery." order by ".$columnName
                ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $pproduit=$stmt->executeQuery();
          $empRecords = $pproduit->fetchAll();
        
          
        
          
            $data = array();
  
            foreach( $empRecords as $row ){

                // $html = $this->renderView('reception/actionsCab.html.twig', array(
                //     'id' => $row['code_livraison']
                // ));  
                
            $data[] = array(
                              "id"                 =>$row['id'],
                              "designation"        =>$row['designation'],
                              "prix_achat"         =>$row['prix_achat'],
                              "prix_vente"         =>$row['prix_vente'],
                              "n_lot"              =>$row['n_lot'],
                              "date_exp"           =>$row['date_exp'],
                              "code_barre"         =>$row['code_barre'],
                              "tva"                =>$row['tva'],
                              "conditionnement"    =>$row['conditionnement'],
                              "code_zone"          =>$row['code_zone'],
                              "qte_reste"          =>$row['qte_reste'],
                               //   "actions"=> $html,
                              );
            }

  
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
  
          return new JsonResponse($response);
    }

    public function test()
    {
      $session = new Session();
      if(empty($session->get('id_dossier_local'))){
            return $dossier = true ;
      }
    } 
}

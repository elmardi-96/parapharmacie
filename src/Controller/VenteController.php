<?php

namespace App\Controller;

use App\Entity\PProduit;
use App\Entity\PClient;
use App\Entity\TOperationVente;
use App\Entity\TDetailVente;
use App\Entity\PDossier;
use App\Entity\TStock;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;



class VenteController extends AbstractController
{
    /**
     * @Route("/vente", name="vente")
     */
    public function index(): Response
    {
        if ($this->test())
            return $this->redirectToRoute('dossier');

        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
        ]);
    }

    /**
     * @Route("/vente/new", name="vente_new")
     */
    public function vente_new(): Response
    {
        if ($this->test())
            return $this->redirectToRoute('dossier');

        $Clients = $this->getDoctrine()->getRepository(PClient::class) ->findAll(); 
        return $this->render('vente/index.html.twig', [
            'clients' => $Clients,
        ]);
    }

    /**
     * @Route("/vente/get_produit", name="vente_get_produit")
     */
    public function vente_get_produit(Request $request): Response
    {       
            if ($this->test())
                return $this->redirectToRoute('dossier');

            // dd($request->request->get('CB'));
            $PProduit = $this->getDoctrine()->getRepository(PProduit::class) ->findOneByCodeBarre($request->request->get('CB')); 
            

            if(!$PProduit){
                return new JsonResponse('null');
            }else{

                $ProduitsArcticle = $this->getDoctrine()->getRepository(PProduit::class) 
                                     ->findByArticle($PProduit->getArticle()->getId() );
                
                // $QteVendu = 0;
                // // dd($PProduit->getTDetailVentes()->getId);
                // foreach($PProduit->getTDetailVentes() as $DtVente){
                //     $QteVendu = $QteVendu  +  $DtVente->getQuantite();
                // }
            
                // --- le produit est vendu ou nn ---
                if( $PProduit->getQteReste() == 0 )
                {
                    return new JsonResponse('vendu');
                }else{

                    $datee= $PProduit->getDateExp();
                    $CodeMinDate;
                    $id;
        
                    $listProduit =  json_decode($request->request->get('IdProduits'));
        
                    foreach($ProduitsArcticle as $PA){
                        if( $PA->getId() !=  $PProduit->getId()){
                            if($PProduit->getDateExp() >= $PA->getDateExp()){
                                if( $PA->getDateExp() <=  $datee && $PA->getQteReste() != 0 && !in_array($PA->getId(),$listProduit ) ){
                                    $datee = $PA->getDateExp();
                                    $CodeMinDate = $PA->getCodeBarre();
                                }
                            }
                        }
                    }
        
                    if($datee != $PProduit->getDateExp()  ){
                        $arr = array(
                            0 => "DateMin", 
                            1 =>  $datee , 
                            2 =>  $CodeMinDate
                        );
                        return new JsonResponse($arr);
        
                    }else{
                            $Produit['id']                  = $PProduit->getId();
                            $Produit['designation']         = $PProduit->getDesignation();
                            $Produit['prixVente']           = $PProduit->getPrixVente();
                            $Produit['qteReste']            = $PProduit->getQteReste();
                            $Produit['codeZone']            = $PProduit->getCodeZone();
                            $Produit['conditionnement']     = $PProduit->getConditionnement();
                            $Produit['detExp']              = $PProduit->getDateExp();  

                            return new JsonResponse($Produit);
                    }
                    
                }

            }

            
        
        
            
    }

    /**
     * @Route("/vente/insert", name="vente_insert" , methods={"GET","POST"})
     */
    public function vente_insert(Request $request): Response
    {
            if ($this->test())
                  return $this->redirectToRoute('dossier');

            $session = new Session();

            $Allproduits = json_decode($request->request->get('Allproducts'));

            $entityManager = $this->getDoctrine()->getManager();

            $TOperationVente = new TOperationVente();
            
            $PDossier = $this->getDoctrine()->getRepository(PDossier::class) ->findOneById($session->get('id_dossier_local')); 
            $TOperationVente->setDossier($PDossier);

            $PClient = $this->getDoctrine()->getRepository(PClient::class) ->findOneById($Allproduits[0]->client); 
            $TOperationVente->setClient($PClient);

            $TOperationVente->setUserCreate( $this->getUser() );

            $dNow          = new \DateTime(date("Y/m/d"));
            $TOperationVente->setDateCreation($dNow);
            $TOperationVente->setDateVente($dNow);
            
            $entityManager->persist($TOperationVente);

            
            foreach( $Allproduits as $produit){

                $TDetailVente = new TDetailVente();
            
                $PDossier = $this->getDoctrine()->getRepository(PDossier::class) ->findOneById($session->get('id_dossier_local')); 
                $TDetailVente->setDossier($PDossier);
    
                $TDetailVente->setUserCreate( $this->getUser());
                $TDetailVente->setOprationVente($TOperationVente);
    
                $dNow = new \DateTime(date("Y/m/d"));
                $TDetailVente->setDateCreation($dNow);
                $TDetailVente->setQuantite($produit->qteReste);
                $TDetailVente->setPrixUnitaire($produit->prixVente);
                $TDetailVente->setPrixTtc($produit->prixVente);

                $PProduit = $this->getDoctrine()->getRepository(PProduit::class) ->findOneById($produit->id); 
                $TDetailVente->setProduit($PProduit);

                $entityManager->persist($TDetailVente);
                
                // ----- quantite du produit  qui reste aprés la vente  ----
                $qte = $PProduit->getQteReste() - $produit->qteReste;
                $PProduit->setQteReste($qte);

                // ----- quantite du stock  qui reste aprés la vente  ----
                $TStock   = $this->getDoctrine()->getRepository(TStock::class)->findOneByArticle( $PProduit->getArticle()->getId() );
                $qteStock = $TStock->getQuantite() - $produit->qteReste;
                $TStock->setQuantite($qteStock);


            }
            
            $entityManager->flush();

            return new JsonResponse('ok');

    }

    /**
     * @Route("/vente/home", name="vente_home" )
     */
    public function vente_home(Request $request): Response
    {
        if ($this->test())
            return $this->redirectToRoute('dossier');

        return $this->render('vente/vente.html.twig', [
            'controller_name' => 'VenteController',
        ]);

    }


    /**
     * @Route("/vente/operation_data", name="vente_operation_data")
     */
    public function operation_data(): Response
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
                                     nom               like '%".$searchValue."%' or
                                     date_vente        like '%".$searchValue."%' or
                                   )";
          }
          

          $sel="  SELECT count(*) as allcount
                  FROM toperation_vente where  	dossier_id = " .$session->get('id_dossier_local') ;

          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecords = $result['allcount'];

          $sel=" SELECT count(*) as allcount
                 FROM  toperation_vente
                 where dossier_id = " .$session->get('id_dossier_local') ."  ".$searchQuery;

          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecordwithFilter = $result['allcount'] ;

        //   dd($totalRecordwithFilter);

         
  
          ## Fetch records
          $sel=" SELECT client.nom, vente.*
                 FROM toperation_vente as vente 
                 inner join pclient as client on client.id = vente.client_id 
                 where dossier_id = " .$session->get('id_dossier_local') ." ".$searchQuery." order by ".$columnName  ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $empRecords = $stmt->fetchAll();
          
            $data = array();

            foreach( $empRecords as $row ){

                $html = $this->renderView('vente/actionVente.html.twig', array(
                    'id' => $row['id']
                )); 
                

                $data[] = array(
                                "id"                 => $row['id'],
                                "nom"                => $row['nom'],
                                "date_vente"         => $row['date_vente'],
                                "date_creation"      => $row['date_creation'],
                                "actions"=> $html,

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


    /**
     * @Route("/vente/det", name="vente_det" )
     */
    public function vente_det(Request $request): Response
    {
        if ($this->test())
            return $this->redirectToRoute('dossier');

        $idOP = $_GET['op'] ;
        return $this->render('vente/venteDet.html.twig', [
            'idOP' =>  $idOP,
        ]);

    }




     /**
     * @Route("/vente/det_data", name="vente_det_data")
     */
    public function vente_det_data(Request $request): Response
    {   
        if ($this->test())
            return $this->redirectToRoute('dossier');
            
        $idOP = $_GET['op'] ;
        //   $session = new Session();
           
        ## Read value

        //   dd($_POST['draw']);
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
                                     venteDet.id              like '%".$searchValue."%' or 
                                     produit_id               like '%".$searchValue."%' or  
                                     prix_unitaire            like '%".$searchValue."%' or
                                     prix_ttc                 like '%".$searchValue."%' or
                                     datetime                 like '%".$searchValue."%' or
                                     venteDet.date_creation   like '%".$searchValue."%' or
                                     quantite                 like '%".$searchValue."%'
                                   )";
          }

          $sel="  SELECT count(*) as allcount
                  FROM tdetail_vente as venteDet 
                  WHERE 1 and opration_vente_id =  $idOP "  ;
                  
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecords = $result['allcount'];

          $sel="  SELECT count(*) as allcount
                  FROM tdetail_vente as venteDet 
                  WHERE 1 and opration_vente_id =  $idOP ".$searchQuery;

          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecordwithFilter = $result['allcount'] ;


          ## Fetch records
          $sel=" SELECT venteDet.*, produit.designation
                 FROM tdetail_vente as venteDet 
                 inner join pproduit as produit on produit.id = venteDet.produit_id 
                 WHERE 1 and opration_vente_id =  $idOP ".$searchQuery." order by ".$columnName 
                ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $empRecords = $stmt->fetchAll();
        
          
            $data = array();
  
            foreach( $empRecords as $row ){

                // $html = $this->renderView('reception/actionDet.html.twig', array(
                //     'id' => $row['id']
                // )); 

                $data[] = array(

                    "id"                =>$row['id'],
                    "produit_id"        =>$row['produit_id'],
                    "prix_unitaire"     =>$row['prix_unitaire'],
                    "prix_ttc"          =>$row['prix_ttc'],
                    "datetime"          =>$row['datetime'],
                    "date_creation"     =>$row['date_creation'],
                    "quantite"          =>$row['quantite'],
                    //   "actions"            =>$html,
                    //   "dateoperation"      =>$row['dateoperation'],
                    // "actions"=> $html,

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

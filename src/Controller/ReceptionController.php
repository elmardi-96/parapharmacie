<?php

namespace App\Controller;

use App\Entity\PArticle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;



class ReceptionController extends AbstractController
{


    

    /**
     * @Route("/reception", name="reception")
     */
    public function index(): Response
    { 
        if ($this->test())
            return $this->redirectToRoute('dossier');

        return $this->render('reception/index.html.twig', [
            'controller_name' => 'ReceptionController',
        ]);
    }


    /**
     * @Route("/reception_data/lvcab", name="reception_data_lvcab")
     */
    public function reception_data_lvcab(): Response
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
              $searchQuery = " and ( code_livraison  like '%".$seachValue."%' or 
                                     date_livraison  like '%".$searchValue."%' or 
                                     remise         like'%".$searchValue."%' or 
                                     date_remise     like'%".$searchValue."%' or
                                     mt_remise       like'%".$searchValue."%'  or
                                     dat_eoperation  like'%".$searchValue."%' 
                                   )";
          }
          
          ## Total number of records without filtering
          $sel=" select count(*) as allcount from vlivraisoncab where dossier_id = " . $session->get('id_dossier_local')  ;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecords = $result['allcount'];

        //   dd($totalRecords);
  
  
          ## Total number of records with filtering
          $sel=" select count(*) as allcount from vlivraisoncab WHERE 1 and dossier_id = " . $session->get('id_dossier_local') .' '.$searchQuery;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecordwithFilter = $result['allcount'] ;
         
  
          ## Fetch records
          $sel="select * from vlivraisoncab WHERE 1 and dossier_id = " . $session->get('id_dossier_local') .' '.$searchQuery." order by ".$columnName
                ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $empRecords = $stmt->fetchAll();
        
          
        
          
            $data = array();
  
            foreach( $empRecords as $row ){

                $html = $this->renderView('reception/actionsCab.html.twig', array(
                    'id' => $row['code_livraison']
                ));       
              $data[] = array(
                              "id"       =>$row['id'],
                              "dossier_id"        =>$row['dossier_id'],
                              "code_livraison"     =>$row['code_livraison'],
                              "date_livraison"     =>$row['date_livraison'],
                              "remise"            =>$row['remise'],
                              "date_remise"        =>$row['date_remise'],
                              "mt_remise"          =>$row['mt_remise'],
                              "date_operation"     =>$row['date_operation'],
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
     * @Route("/reception/det", name="reception_det")
     */
    public function reception_det(): Response
    { 
        if ($this->test())
            return $this->redirectToRoute('dossier');

        $idCab = $_GET['code'] ;
        $articles = $this->getDoctrine()->getRepository(PArticle::class) ->findAll();

        return $this->render('reception/receptionDet.html.twig', [
            'idCab' =>  $idCab,
            'articles'  => $articles
        ]);
    }

    /**
     * @Route("/reception_data/lvdet", name="reception_data_lvdet")
     */
    public function reception_data_lvdet(): Response
    {   
          if ($this->test())
             return $this->redirectToRoute('dossier');

          $idCab = $_GET['code'] ;
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
                                     code_livraison      like '%".$searchValue."%' or 
                                     article             like '%".$searchValue."%' or 
                                     unite               like '%".$searchValue."%' or 
                                     quantite            like '%".$searchValue."%' or
                                     pri_unitaire        like '%".$searchValue."%' or
                                     tva                 like '%".$searchValue."%' or
                                     prix_ttc            like '%".$searchValue."%'
                                   )";
          }
          
          ## Total number of records without filtering
          // $sel=" select  from vlivraisondet where code_livraison = '" . $idCab."'" ;
          $sel="  SELECT count(*) as allcount
                  FROM vlivraisondet as det 
                  inner join vlivraisoncab as cab on cab.id = det.livraisoncab_id 
                  left join pproduit as produit on produit.livraisondet_id = det.id
                  WHERE 1 and produit.id is null and code_livraison = '" . $idCab."'" ;
          // dd($sel);
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecords = $result['allcount'];

        //   dd($totalRecords);
  
  
          ## Total number of records with filtering
          // $sel=" select count(*) as allcount from vlivraisondet WHERE 1 and code_livraison = '" . $idCab ."' ".$searchQuery;
          $sel="  SELECT count(*) as allcount
                  FROM vlivraisondet as det 
                  inner join vlivraisoncab as cab on cab.id = det.livraisoncab_id 
                  left join pproduit as produit on produit.livraisondet_id = det.id
                  WHERE 1 and produit.id is null  and code_livraison =  '" . $idCab ."' ".$searchQuery;
          // if(!empty($searchValue))
          // dd($sel);
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecordwithFilter = $result['allcount'] ;

        //   dd($totalRecordwithFilter);

         
  
          ## Fetch records
          $sel=" SELECT det.*, cab.code_livraison
                 FROM vlivraisondet as det 
                 inner join vlivraisoncab as cab on cab.id = det.livraisoncab_id 
                 left join pproduit as produit on produit.livraisondet_id = det.id
                 WHERE 1  and produit.id is null and code_livraison = '" . $idCab ."' ".$searchQuery." order by ".$columnName  ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $empRecords = $stmt->fetchAll();
        
        //   dd($empRecords);
        
          
            $data = array();
  
            foreach( $empRecords as $row ){

                $html = $this->renderView('reception/actionDet.html.twig', array(
                    'id' => $row['id']
                )); 
                // idlivraison ,id_dossier , codelivraison , datelivraison , remise , dateremise , mtremise , dateoperation    
              $data[] = array(
                              "code_livraison"     =>$row['code_livraison'],
                              "article"            =>$row['article'],
                              "unite"              =>$row['unite'],
                              "quantite"           =>$row['quantite'],
                              "pri_unitaire"       =>$row['pri_unitaire'],
                              "tva"                =>$row['tva'],
                              "prix_ttc"           =>$row['prix_ttc'],
                              "actions"            =>$html,
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

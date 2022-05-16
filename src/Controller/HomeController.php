<?php

namespace App\Controller;

use App\Entity\PDossier;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;




class HomeController extends AbstractController
{

    // /**
    //  * @Route("/", name="test")
    //  */
    // public function test(Request $request): Response
    // { 
    //     return $this->redirectToRoute('dossier');
    // }

    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request): Response
    { 
       
        $session = new Session();
        // $session->clear();
        // dd($session->get('dossier'));

        if(!empty($session->get('id_dossier_local'))){

            return $this->render('home/index.html.twig');

        }elseif( !empty($request->request->get('dossier'))   &&  $request->request->get('dossier') != "empty" ){

                $id_dossier = $request->request->get('dossier');
                $dossier    = $this->getDoctrine()->getRepository(PDossier::class) ->findOneById($id_dossier);

                $id_dossier_local =  $dossier->getId();
                $id_dossier_ugouv =  $dossier->getIdUgouv();

                $session->set('id_dossier_ugouv',$id_dossier_ugouv );
                $session->set('id_dossier_local',$id_dossier_local );

                return $this->render('home/index.html.twig', [
                    'controller_name' => 'HomeController',
                ]);
        }else{
            
            // $session = new Session();
            // $session->clear();
            return $this->redirectToRoute('dossier');
        }
        
    }

    /**
     * @Route("/parametrage", name="parametrage")
     */
    public function parametrage(): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('home/parametrage.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/datatable", name="datatable")
     */
    public function datatable(): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

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
            $searchQuery = " and ( code like '%".$searchValue."%' or 
                                   nom  like '%".$searchValue."%' or 
                                   abreviation  like'%".$searchValue."%' or 
                                   description  like'%".$searchValue."%' 
                                 )";
        }
        
        ## Total number of records without filtering
        $sel="select count(*) as allcount from pdossier";
        $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
        $stmt->execute();
        $result = $stmt->fetch();
        $totalRecords = $result['allcount'];


        ## Total number of records with filtering
        $sel="select count(*) as allcount from pdossier WHERE 1 ".$searchQuery;
        $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
        $stmt->execute();
        $result = $stmt->fetch();
        $totalRecordwithFilter = $result['allcount'] ;

        ## Fetch records
        $sel="select * from pdossier WHERE 1 ".$searchQuery." order by ".$columnName
              ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
        $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
        $stmt->execute();
        $empRecords = $stmt->fetchAll();
        
        $data = array();

        foreach( $empRecords as $row ){

            $data[] = array(
                            "id"=>$row['id'],
                            "code"=>$row['code'],
                            "nom"=>$row['nom'],
                            "abreviation"=>$row['abreviation'],
                            "description"=>$row['description'],
                            "actions"=>'<i class="fas fa-eye"></i>',

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

   

}

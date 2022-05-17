<?php

namespace App\Controller;

use App\Entity\PClient;
use App\Entity\PDossier;
use App\Form\PClientType;
use App\Repository\PClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * @Route("/p/client")
 */
class PClientController extends AbstractController
{
    /**
     * @Route("/", name="p_client_index", methods={"GET"})
     */
    public function index(PClientRepository $pClientRepository): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_client/index.html.twig', [
            'p_clients' => $pClientRepository->findAll(),
        ]);
    }
    

    /**
     * @Route("/new", name="p_client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');
             
        $session = new Session();

        $pClient = new PClient();
        $form = $this->createForm(PClientType::class, $pClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $PDossier = $this->getDoctrine()->getRepository(PDossier::class) ->findOneById($session->get('id_dossier_local')); 
            $pClient->setDossier($PDossier);

            $pClient->setUserCreate($this->getUser());

            $dNow        = new \DateTime(date("Y/m/d"));
            $pClient->setdateCreation($dNow);
            $entityManager->persist($pClient);
            $entityManager->flush();

            return $this->redirectToRoute('p_client_index');
        }

        return $this->render('p_client/new.html.twig', [
            'p_client' => $pClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="p_client_show", methods={"GET"})
     */
    public function show(PClient $pClient): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_client/show.html.twig', [
            'p_client' => $pClient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="p_client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PClient $pClient): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        $form = $this->createForm(PClientType::class, $pClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('p_client_index');
        }

        return $this->render('p_client/edit.html.twig', [
            'p_client' => $pClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="p_client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PClient $pClient): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');
             
        if ($this->isCsrfTokenValid('delete'.$pClient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('p_client_index');
    }




    /**
     * @Route("/client_data", name="client_data")
     */
    public function client_data(PClientRepository $pClientRepository): Response
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
              $searchQuery = " and ( nom like '%".$searchValue."%' or 
                                     prenom  like '%".$searchValue."%' or 
                                     adresse  like'%".$searchValue."%' or 
                                     tel  like'%".$searchValue."%' or
                                     email  like'%".$searchValue."%'  or
                                     date_creation  like'%".$searchValue."%' 
                                   )";
          }
          
          ## Total number of records without filtering
          $sel=" select count(*) as allcount from pclient 
                 where dossier_id = " . $session->get('id_dossier_local') ;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
        //   $stmt->execute(); 
          $test=$stmt->executeQuery();
          $result = $test->fetch();
          $totalRecords = $result['allcount'];

        //   dd($totalRecords);
  
  
          ## Total number of records with filtering
          $sel="  select count(*) as allcount from pclient WHERE 1 
                  and dossier_id = " . $session->get('id_dossier_local') . " ".$searchQuery;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
        //   $stmt->execute();
          $test=$stmt->executeQuery();
          $result = $test->fetch();
          $totalRecordwithFilter = $result['allcount'] ;
         
  
          ## Fetch records
          $sel=" select * from pclient 
                 WHERE 1 and dossier_id = " . $session->get('id_dossier_local') 
                 . " ".$searchQuery." order by ".$columnName ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $test=$stmt->executeQuery();
          $empRecords = $test->fetchAll();
        
          
        
          
            $data = array();
  
            foreach( $empRecords as $row ){
                
                $html = $this->renderView('p_client/actions.html.twig', array(
                    'id' => $row['id']
                ));            
                $data[] = array(
                              "id"      =>$row['id'],
                              "nom"     =>$row['nom'],
                              "prenom"  =>$row['prenom'],
                              "adresse" =>$row['adresse'],
                              "tel"     =>$row['tel'],
                              "email"   =>$row['email'],
                              "date_creation"=>$row['date_creation'],
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

    public function test()
    {
      $session = new Session();
      if(empty($session->get('id_dossier_local'))){
            return $dossier = true ;
      }
    } 

}

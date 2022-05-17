<?php

namespace App\Controller;

use App\Entity\PFornisseur;
use App\Form\PFornisseurType;
use App\Repository\PFornisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/p/fornisseur")
 */
class PFornisseurController extends AbstractController
{
    /**
     * @Route("/", name="p_fornisseur_index", methods={"GET"})
     */
    public function index(PFornisseurRepository $pFornisseurRepository): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_fornisseur/index.html.twig', [
            'p_fornisseurs' => $pFornisseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="p_fornisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        $pFornisseur = new PFornisseur();
        $form = $this->createForm(PFornisseurType::class, $pFornisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pFornisseur);
            $entityManager->flush();

            return $this->redirectToRoute('p_fornisseur_index');
        }

        return $this->render('p_fornisseur/new.html.twig', [
            'p_fornisseur' => $pFornisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="p_fornisseur_show", methods={"GET"})
     */
    public function show(PFornisseur $pFornisseur): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_fornisseur/show.html.twig', [
            'p_fornisseur' => $pFornisseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="p_fornisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PFornisseur $pFornisseur): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        $form = $this->createForm(PFornisseurType::class, $pFornisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('p_fornisseur_index');
        }

        return $this->render('p_fornisseur/edit.html.twig', [
            'p_fornisseur' => $pFornisseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="p_fornisseur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PFornisseur $pFornisseur): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        if ($this->isCsrfTokenValid('delete'.$pFornisseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pFornisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('p_fornisseur_index');
    }

    /**
     * @Route("/fornisseur_data", name="fornisseur_data")
     */
    public function fornisseur_data(): Response
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
              $searchQuery = " and ( nom like '%".$searchValue."%' or 
                                     prenom  like '%".$searchValue."%' or 
                                     adresse  like'%".$searchValue."%' or 
                                     tel  like'%".$searchValue."%' or
                                     email  like'%".$searchValue."%'  or
                                     date_creation  like'%".$searchValue."%' 
                                   )";
          }
          
          ## Total number of records without filtering
          $sel="select count(*) as allcount from pfornisseur";
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $pfournisseur=$stmt->executeQuery();
          $result =$pfournisseur->fetch();
          $totalRecords = $result['allcount'];

        //   dd($totalRecords);
  
  
          ## Total number of records with filtering
          $sel="select count(*) as allcount from pfornisseur WHERE 1 ".$searchQuery;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $pfournisseur=$stmt->executeQuery();
          $result = $pfournisseur->fetch();
          $totalRecordwithFilter = $result['allcount'] ;
         
  
          ## Fetch records
          $sel="select * from pfornisseur WHERE 1 ".$searchQuery." order by ".$columnName
                ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $pfournisseur=$stmt->executeQuery();
          $empRecords = $pfournisseur->fetchAll();
        
          
        
          
            $data = array();
  
            foreach( $empRecords as $row ){

                $html = $this->renderView('p_fornisseur/actions.html.twig', array(
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

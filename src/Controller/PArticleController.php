<?php

namespace App\Controller;

use App\Entity\PArticle;
use App\Entity\PDossier;
use App\Form\PArticleType;
use App\Repository\PArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * @Route("/p/article")
 */
class PArticleController extends AbstractController
{
    /**
     * @Route("/", name="p_article_index", methods={"GET"})
     */
    public function index(PArticleRepository $pArticleRepository): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_article/index.html.twig', [
            'p_articles' => $pArticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="p_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        $session = new Session();

        $pArticle = new PArticle();
        $form = $this->createForm(PArticleType::class, $pArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $PDossier = $this->getDoctrine()->getRepository(PDossier::class) ->findOneById($session->get('id_dossier_local')); 
            $pArticle->setDossier($PDossier);

            $pArticle->setUserCreate($this->getUser());

            $dNow        = new \DateTime(date("Y/m/d"));
            $pArticle->setdateCreation($dNow);
            $entityManager->persist($pArticle);
            $entityManager->flush();

            return $this->redirectToRoute('p_article_index');
        }

        return $this->render('p_article/new.html.twig', [
            'p_article' => $pArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="p_article_show", methods={"GET"})
     */
    public function show(PArticle $pArticle): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        return $this->render('p_article/show.html.twig', [
            'p_article' => $pArticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="p_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PArticle $pArticle): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        $form = $this->createForm(PArticleType::class, $pArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('p_article_index');
        }

        return $this->render('p_article/edit.html.twig', [
            'p_article' => $pArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="p_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PArticle $pArticle): Response
    {
        if ($this->test())
             return $this->redirectToRoute('dossier');

        if ($this->isCsrfTokenValid('delete'.$pArticle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('p_article_index');
    }

    
    /**
     * @Route("/article_data", name="article_data")
     */
    public function article_data(PArticleRepository $pArticleRepository): Response
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
              $searchQuery = " and (  designation like '%".$searchValue."%' or 
                                      abreviation  like '%".$searchValue."%' or 
                                      date_creation  like'%".$searchValue."%' 
                                   )";
          }
          
          ## Total number of records without filtering
          $sel="select count(*) as allcount from particle where dossier_id = " . $session->get('id_dossier_local');
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecords = $result['allcount'];

        //   dd($totalRecords);
  
  
          ## Total number of records with filtering
          $sel="select count(*) as allcount from particle 
                WHERE 1 and dossier_id = " . $session->get('id_dossier_local') . " " .$searchQuery;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $result = $stmt->fetch();
          $totalRecordwithFilter = $result['allcount'] ;
         
  
          ## Fetch records
          $sel="select * from particle 
                WHERE 1 and dossier_id = " . $session->get('id_dossier_local') . " ".$searchQuery." order by ".$columnName
                ." ".$columnSortOrder." limit ".$row.",".$rowperpage;
          $stmt = $this->getDoctrine()->getConnection()->prepare($sel);
          $stmt->execute();
          $empRecords = $stmt->fetchAll();
        
          
        
          
            $data = array();
  
            foreach( $empRecords as $row ){
                
                $html = $this->renderView('p_article/actions.html.twig', array(
                    'id' => $row['id']
                ));            
              $data[] = array(
                              "id"      =>$row['id'],
                              "designation"     =>$row['designation'],
                              "abreviation"  =>$row['abreviation'],
                              "date_creation" =>$row['date_creation'],
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

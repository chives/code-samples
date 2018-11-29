<?php 

namespace Adevo\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Adevo\NewsBundle\Entity\Post;
use Adevo\AdminBundle\Form\Type\PostType;


class PostsController extends Controller
{
    private $delete_token_name = "delete-post-%d";
    
    
    /**
     * @Route(
     *      "/list/{status}/{page}", 
     *      name="admin_postsList",
     *      requirements={"page"="\d+"},
     *      defaults={"status"="all", "page"=1}
     * )
     * 
     * @Template()
     */
    public function indexAction(Request $request, $status, $page) {
        
        $queryParams = array(
            'titleLike' => $request->query->get('titleLike'),
            'categoryId' => $request->query->get('categoryId'),
            'status' => $status,
            'orderBy' => 'p.createDate',
            'orderDir' => 'DESC'
        );
        
        $PostRepository = $this->getDoctrine()->getRepository('AdevoNewsBundle:Post');
        $statistics = $PostRepository->getStatistics();
        $qb = $PostRepository->getQueryBuilder($queryParams);
        $paginationLimit = '5';
        $limits = array(2, 5, 10, 15); 
        $limit = $request->query->get('limit', $paginationLimit);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $limit);
        $categoriesList = $this->getDoctrine()->getRepository('AdevoNewsBundle:Category')->getAsArray();
        $statusesList = array(
            'Wszystkie' => 'all',
            'Opublikowane' => 'published',
            'Nieopublikowane' => 'unpublished'
        );
        
        return array(
            'currPage' => 'posts',
            'queryParams' => $queryParams,
            'categoriesList' => $categoriesList,
            
            'limits' => $limits,
            'currLimit' => $limit,
            
            'statusesList' => $statusesList,
            'currStatus' => $status,
            'statistics' => $statistics,
            
            'pagination' => $pagination,
            'currLimit' => $limit,
            'currStatus' => $status,
            
            'deleteTokenName' => $this->delete_token_name,
            'csrfProvider' => $this->get('form.csrf_provider')
        );
    }
    
    
    /**
     * @Route(
     *      "/form/{id}", 
     *      name="admin_postForm",
     *      requirements={"id"="\d+"},
     *      defaults={"id"=NULL}
     * )
     * 
     * @Template()
     */
    public function formAction(Request $Request, $id = NULL) {
           
        if(null == $id){
            $Post = new Post();
            $Post->setAuthor($this->getUser());
            $newPostForm = TRUE;
        }else{
            $Post = $this->getDoctrine()->getRepository('AdevoNewsBundle:Post')->find($id);
        }
       
        $form = $this->createForm(new PostType(), $Post);
        $form->handleRequest($Request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($Post);
            $em->flush();
            $message = (isset($newPostForm)) ? 'Poprawnie dodano nowy post!': 'Post został poprawiony!';
            $this->get('session')->getFlashBag()->add('success', $message);
            return $this->redirect($this->generateUrl('admin_postForm', array(
                'id' => $Post->getId()
            )));
        } else if ($form->isSubmitted() && $form->isValid() === false){
            $message = 'Popraw błędy formularza!';
            $this->get('session')->getFlashBag()->add('error', $message);
        }
        
        return array(
            'currPage' => 'posts',
            'form' => $form->createView(),
            'post' => $Post
        );
    }
    
    
    /**
     * @Route(
     *      "/delete/{id}/{token}", 
     *      name="admin_postDelete",
     *      requirements={"id"="\d+"}
     * )
     * 
     * @Template()
     */
    public function deleteAction($id, $token) {
        
        $tokenName = sprintf($this->delete_token_name, $id);
        $csrfProvider = $this->get('form.csrf_provider');
        
        if(!$csrfProvider->isCsrfTokenValid($tokenName, $token)){
            $this->get('session')->getFlashBag()->add('error', 'Niepoprawny token akcji!');
        }else{
            $Post = $this->getDoctrine()->getRepository('AdevoNewsBundle:Post')->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Post);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Poprawnie usunięto post wraz ze wszystkimi komentarzami');
        }
        
        return $this->redirect($this->generateUrl('admin_postsList'));
    }
}

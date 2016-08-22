<?php

namespace Ens\JobeetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ens\JobeetBundle\Entity\Category;
// use Ens\JobeetBundle\Form\CategoryType;

/**
 * Job controller.
 *
 */
class CategoryController extends Controller
{
    public function showAction($slug, $page)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('EnsJobeetBundle:Category')->findOneBySlug($slug);
         
          if (!$category) {
            throw $this->createNotFoundException('Unable to find Category entity.');
          }
         
          $total_jobs = $em->getRepository('EnsJobeetBundle:Job')->countActiveJobs($category->getId());
          $jobs_per_page = $this->container->getParameter('max_jobs_on_category');
          $last_page = ceil($total_jobs / $jobs_per_page);
          $previous_page = $page > 1 ? $page - 1 : 1;
          $next_page = $page < $last_page ? $page + 1 : $last_page;
         
          $category->setActiveJobs($em->getRepository('EnsJobeetBundle:Job')->getActiveJobs($category->getId(), $jobs_per_page, ($page - 1) * $jobs_per_page));
         
          return $this->render('EnsJobeetBundle:Category:show.html.twig', array(
            'category' => $category,
            'last_page' => $last_page,
            'previous_page' => $previous_page,
            'current_page' => $page,
            'next_page' => $next_page,
            'total_jobs' => $total_jobs
          ));
     
        // $category = $em->getRepository('EnsJobeetBundle:Category')->findOneBySlug($slug);
     
        // if (!$category) {
        //     throw $this->createNotFoundException('Unable to find Category entity.');
        // }
     
        // $category->setActiveJobs($em->getRepository('EnsJobeetBundle:Job')->getActiveJobs($category->getId()));
     
        // return $this->render('EnsJobeetBundle:Category:show.html.twig', array(
        //     'category' => $category,
        // ));
    }


    /**
     * Lists all Job entities.
     *
     */
    // public function indexAction()
    // {
    //     $em = $this->getDoctrine()->getManager();

    //     $categories = $em->getRepository('EnsJobeetBundle:Category')->getWithJobs();


    //     foreach($categories as $category)
    //     {
    //       $category->setActiveJobs($em->getRepository('EnsJobeetBundle:Job')->getActiveJobs($category->getId(), $this->container->getParameter('max_jobs_on_homepage')));

    //         $category->setMoreJobs($em->getRepository('EnsJobeetBundle:Job')->countActiveJobs($category->getId()) - $this->container->getParameter('max_jobs_on_homepage'));

    //     }
        
    //     return $this->render('EnsJobeetBundle:Job:index.html.twig', array(
    //       'categories' => $categories
    //     ));
    // }

    /**
     * Creates a new Job entity.
     *
     */
    // public function newAction(Request $request)
    // {
    //     $job = new Job();
    //     $form = $this->createForm('Ens\JobeetBundle\Form\JobType', $job);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($job);
    //         $em->flush();

    //         return $this->redirectToRoute('ens_job_show', array('id' => $job->getId()));
    //     }

    //     return $this->render('job/new.html.twig', array(
    //         'job' => $job,
    //         'form' => $form->createView(),
    //     ));
    // }

    /**
     * Finds and displays a Job entity.
     *
     */
    // public function showAction($id)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $job = $em->getRepository('EnsJobeetBundle:Job')->getActiveJob($id);

    //     $deleteForm = $this->createDeleteForm($job);

    //     return $this->render('EnsJobeetBundle:Job:show.html.twig', array(
    //         'job' => $job,
    //         'delete_form' => $deleteForm->createView(),
    //     ));
    // }

    /**
     * Displays a form to edit an existing Job entity.
     *
     */
    // public function editAction(Request $request, Job $job)
    // {
    //     $deleteForm = $this->createDeleteForm($job);
    //     $editForm = $this->createForm('Ens\JobeetBundle\Form\JobType', $job);
    //     $editForm->handleRequest($request);

    //     if ($editForm->isSubmitted() && $editForm->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($job);
    //         $em->flush();

    //         return $this->redirectToRoute('ens_job_edit', array('id' => $job->getId()));
    //     }

    //     return $this->render('job/edit.html.twig', array(
    //         'job' => $job,
    //         'edit_form' => $editForm->createView(),
    //         'delete_form' => $deleteForm->createView(),
    //     ));
    // }

    /**
     * Deletes a Job entity.
     *
     */
    // public function deleteAction(Request $request, Job $job)
    // {
    //     $form = $this->createDeleteForm($job);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->remove($job);
    //         $em->flush();
    //     }

    //     return $this->redirectToRoute('ens_job_index');
    // }

    /**
     * Creates a form to delete a Job entity.
     *
     * @param Job $job The Job entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    // private function createDeleteForm(Job $job)
    // {
    //     return $this->createFormBuilder()
    //         ->setAction($this->generateUrl('ens_job_delete', array('id' => $job->getId())))
    //         ->setMethod('DELETE')
    //         ->getForm()
    //     ;
    // }
}

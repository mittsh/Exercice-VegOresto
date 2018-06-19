<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Restaurant;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        $q = trim($request->query->get('q'));

        $em = $this->getDoctrine()->getManager();
        $qb = $em
            ->createQueryBuilder()
            ->select('r')
            ->from('App\Entity\Restaurant', 'r')
            ->setMaxResults(20);

        if (!empty($q)) {
            $qb
                ->where('r.title LIKE :q')
                ->setParameter('q', '%' . $q . '%');
        }

        $query = $qb->getQuery();
        $restaurants = $query->getResult();
        return $this->render('index.html.twig', [
            'restaurants' => $restaurants,
            'q' => $q,
        ]);
    }
}

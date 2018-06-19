<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Restaurant;

class ImportRestaurantsController extends Controller
{
    public function importRestaurants($json)
    {
        foreach ($json as $d) {
            $this->importRestaurant($d);
        }

        // flush in database
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return count($json);
    }

    private function importRestaurant($d)
    {
        $id = $d['objectID'];
        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)->find($id);
        if ($restaurant) {
            // already imported, skip
            return false;
        }

        // create a Restaurant object
        $restaurant = new Restaurant();
        $restaurant->setCreatedAt(new \DateTime('now'));
        $restaurant->setTitle($d['title']);
        $restaurant->setDescription($d['description']);
        $restaurant->setPermalink($d['permalink']);
        $restaurant->setVegan($d['vegan_category']);
        $restaurant->setAddress($d['address']['address']);
        $restaurant->setRatings($d['ratings']['avg'] ?: 0);
        $restaurant->setCategories($d['culinary_categories']);

        // persist
        $em = $this->getDoctrine()->getManager();
        $em->persist($restaurant);

        return true;
    }
}

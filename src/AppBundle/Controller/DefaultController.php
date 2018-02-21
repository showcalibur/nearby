<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        // return $this->render('default/index.html.twig', [
        //     'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        // ]);

        // replace this example code with whatever you need
        return $this->render('default/nearby.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/api/v1/hello", name="hello")
     */
    public function indexHello(Request $request)
    {
        $response = new Response(json_encode(array('name' => 'hello')));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/v1/searchByName", name="searchByName")
     */

    // Example : http://127.0.0.1:8000/api/v1/searchByName?name=Eldorado
    public function searchByName(Request $request)
    {
        $name = strtolower($request->query->get('name'));
        $au_postcodes = json_decode(file_get_contents('au_postcodes.json'));
        $result = [];
        foreach ($au_postcodes as $suburb) {
          if (strtolower($suburb->place_name) == $name) $result[] = $suburb;
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/v1/searchByPostcode", name="searchByPostcode")
     */

     // Example : http://127.0.0.1:8000/api/v1/searchNearby?code=2000
    public function searchByPostcode(Request $request)
    {
        $code = $request->query->get('code');
        $au_postcodes = json_decode(file_get_contents('au_postcodes.json'));
        $result = [];
        foreach ($au_postcodes as $suburb) {
          if ($suburb->postcode == $code) $result[] = $suburb;
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Route("/api/v1/searchNearby", name="searchNearby")
     */

     // Example : http://127.0.0.1:8000/api/v1/searchNearby?lat=-37.8915&lng=147.853&distance=10&unit=km
    public function searchNearby(Request $request)
    {
        $lat = (float) $request->query->get('lat');
        $lng = (float) $request->query->get('lng');
        $distance = (float) $request->query->get('distance');
        $unit = 'km';

        // radius of earth; @note: the earth is not perfectly spherical, but this is considered the 'mean radius'
        if ($unit == 'km') $radius = 6371.009; // in kilometers
        elseif ($unit == 'mi') $radius = 3958.761; // in miles

        // latitude boundaries
        $maxLat = (float) $lat + rad2deg($distance / $radius);
        $minLat = (float) $lat - rad2deg($distance / $radius);

        // longitude boundaries (longitude gets smaller when latitude increases)
        $maxLng = (float) $lng + rad2deg($distance / $radius / cos(deg2rad((float) $lat)));
        $minLng = (float) $lng - rad2deg($distance / $radius / cos(deg2rad((float) $lat)));

        // finding nearby
        $au_postcodes = json_decode(file_get_contents('au_postcodes.json'));
        $result = [];
        foreach ($au_postcodes as $suburb) {
          $currentLatitude = (float) $suburb->latitude;
          $currentLongitude = (float) $suburb->longitude;
          $latOk = ($currentLatitude > $minLat) && ($currentLatitude < $maxLat);
          $lngOk = ($currentLongitude > $minLng) && ($currentLatitude < $maxLng);

          if ($latOk && $lngOk) $result[] = $suburb;
        }
        
        $result_num = count($result);
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

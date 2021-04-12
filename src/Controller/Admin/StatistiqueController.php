<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Type;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/statistique")
 */
class StatistiqueController extends AbstractController
{
    public const TEMPLATE = "statistique";

    /**
     * @Route("/", name=self::TEMPLATE)
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->getRepo(new Categorie(), "findAll");
        $types = $this->getRepo(new Type(), "findAll");
        $nbElevesInsc = count($this->getRepo(new User(), "findUserByRole"));
        $nbEventActif = $this->getRepo(new Evenement(), "countEventActif")[0][1];

        // oui c'est du multiple assignement et c'est correct (voir avec divinoPV)
        $nbInscParCateg
            = $nbInscParType
            = $categNom
            = $typesNom
            = $categColor
            = $typeColor
                = []
        ;

        foreach ($categories as $categorie):
            $nbInscParCateg[] = count($categorie->getEvenements()->getValues());
            $categNom[] = $categorie->getNom();
            $categColor[] = $categorie->getColor();
        endforeach;

        foreach ($types as $type):
            $nbInscParType[] = count($type->getEvenements()->getValues());
            $typesNom[] = $type->getNom();
            $typeColor[] = $type->getColor();
        endforeach;

        return $this->render(self::TEMPLATE . "/index.html.twig", [
            "nbInscParCateg" => $this->encode($nbInscParCateg),
            "categNom" => $this->encode($categNom),
            "categColor" => $this->encode($categColor),
            "nbInscParType" => $this->encode($nbInscParType),
            "typesNom" => $this->encode($typesNom),
            "typeColor" => $this->encode($typeColor),
            "nbElevesInsc" => $nbElevesInsc,
            "nbEventActif" => $nbEventActif,
        ]);
    }

    public function encode(array $array, $flag = JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($array, $flag);
    }

    /**
     * Accepte uniquement les méthodes sans param
     * @param object $class
     * @param string $method
     * @return array
     */
    public function getRepo(object $class, string $method): ?array
    {
        return $this
            ->getDoctrine()
            ->getRepository($class::class) // pas touche ça fonctionne très bien ;)
            ->$method(); // idem ;P
    }
}
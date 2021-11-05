<?php

namespace App\Controller;

use App\Service\NotionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var NotionService
     */
    private $notionService;

    public function __construct(NotionService $notionService)
    {
        $this->notionService = $notionService;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'formations' => $this->notionService->getAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function __invoke(string $id): Response
    {
        return $this->render('home/show.html.twig', [
            'formations' => $this->notionService->getOne($id),
        ]);
    }
}

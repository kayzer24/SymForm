<?php


namespace App\Service;


use App\Controller\HomeController;

class StaticDumperService implements \Symplify\SymfonyStaticDumper\Contract\ControllerWithDataProviderInterface
{
    /**
     * @var NotionService
     */
    private $notionService;

    public function __construct(NotionService $notionService)
    {
        $this->notionService = $notionService;
    }

    public function getControllerClass(): string
    {
        return HomeController::class;
    }

    public function getControllerMethod(): string
    {
        return '__invoke';
    }

    /**
     * @inheritDoc
     */
    public function getArguments(): array
    {
        $ids = [];
        foreach ($this->notionService->getAll() as $formation) {
            $ids[] = $formation['id'];
        }

        return $ids;
    }
}
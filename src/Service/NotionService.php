<?php

namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NotionService
{
    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var ParameterBagInterface
     */
    private $param;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $param)
    {
        $this->client = $client;
        $this->param = $param;
    }

    public function makeRequest(?array $body = null): array
    {
        $response = $this->client->request(
            'POST',
            'https://api.notion.com/v1/databases/' . $this->param->get('NOTION_DATABASE') . '/query',
            [
                'auth_bearer' => $this->param->get('NOTION_API'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Notion-Version' => '2021-08-16'
                ],
                'json' => $body
            ]
        );
        return $response->toArray()['results'];
    }

    public function getAll(): array
    {
        return $this->formatData($this->makeRequest());
    }

    public function getOne(string $id): array
    {
        $array = [
            "filter" => [
                "property" => "id",
                "text" => [
                    "equals" => $id
                ]
            ]
        ];
        return $this->formatData($this->makeRequest($array));
    }

    private function formatData(array $data)
    {
        $formattedData = [];

        foreach ($data as $value) {
            $formattedData[] = [
                'id' => $value['properties']['id']['formula']['string'],
                'nom' => $value['properties']['Nom']['title'][0]['plain_text'],
                'resume' => $value['properties']['Resumé']['rich_text'][0]['plain_text'],
                'image' => $value['properties']['Image']['files'][0]['file']['url'] ?? $value['properties']['Image']['files'][0]['file']['url'] = null,
                'lien' => $value['properties']['Lien']['url'],
                'prix' => $value['properties']['Prix']['number'],
            ];
        }

        return $formattedData;
    }
}
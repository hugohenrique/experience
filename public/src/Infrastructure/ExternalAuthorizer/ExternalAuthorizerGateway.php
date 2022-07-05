<?php
declare(strict_types=1);

namespace App\Infrastructure\ExternalAuthorizer;

use DomainException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ExternalAuthorizerGateway
{
    private const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    public function __construct(private HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function authorize(/*User $user, float $value*/): void
    {
        $response = $this->client->request('GET', self::URL);
        $content = $response->getContent();
        $content = $response->toArray();

        if ('Autorizado' !== $content['message']) {
            throw new DomainException('Sua solicitação não foi aprovada.');
        }
    }
}

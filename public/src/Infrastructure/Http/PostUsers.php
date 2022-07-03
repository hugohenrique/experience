<?php
declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Command\RegisterUser;
use App\Application\CommandHandler\RegisterUserCommandHandler;
use App\Application\Service\Validator\RegisterUserValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

use function json_decode;

final class PostUsers
{
    public function __construct(private RegisterUserCommandHandler $commandHandler, RegisterUserValidator $validator)
    {
        $this->commandHandler = $commandHandler;
        $this->validator      = $validator;
    }

    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $violations = $this->validator->validate($payload);

        if (0 !== count($violations)) {
            // throw new ValidationException($violations);
        }

        try {
            $this->commandHandler->handle(
                new RegisterUser(
                    $payload['name'],
                    $payload['cpf'],
                    $payload['emailAddress'],
                    $payload['password']
                )
            );
        } catch (Throwable $th) {
            return new JsonResponse($th->getMessage(), 422);
        }

        return new JsonResponse(null, 202);
    }
}

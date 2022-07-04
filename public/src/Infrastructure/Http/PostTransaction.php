<?php
declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Command\TransferMoney;
use App\Application\CommandHandler\TransferMoneyCommandHandler;
use App\Application\Service\Validator\TransferMoneyValidator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

use function json_decode;

final class PostTransaction
{
    public function __construct(private TransferMoneyCommandHandler $commandHandler, TransferMoneyValidator $validator)
    {
        $this->commandHandler = $commandHandler;
        $this->validator      = $validator;
    }

    /**
     * @Route("/transaction", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $violations = $this->validator->validate($payload);

        if (0 !== count($violations)) {
            throw new BadRequestException($violations);
        }

        try {
            $this->commandHandler->handle(
                new TransferMoney(
                    (int) $payload['payer'],
                    1, // $this->tokenStorage->getUser() = Payee,
                    (float) $payload['value']
                )
            );
        } catch (Throwable $th) {
            return new JsonResponse($th->getMessage(), 422);
        }

        return new JsonResponse(null, 202);
    }
}

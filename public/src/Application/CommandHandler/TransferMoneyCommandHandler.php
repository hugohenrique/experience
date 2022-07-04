<?php
declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\TransferMoney;
use App\Application\Mailer\ReceiptPaymentMailer;
use App\Domain\Exception\UnauthorizedTransferException;
use App\Domain\Model\Shopkeeper;
use App\Domain\Model\Transfer;
use App\Domain\Repository\TransferRepository;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\WalletRepository;
use App\Infrastructure\ExternalAuthorizer\ExternalAuthorizerGateway;

final class TransferMoneyCommandHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private TransferRepository $transferRepository,
        private WalletRepository $walletRepository,
        private ExternalAuthorizerGateway $authorizerGateway,
        private ReceiptPaymentMailer $mailer
    ) {
        $this->userRepository    = $userRepository;
        $this->walletRepository  = $walletRepository;
        $this->authorizerGateway = $authorizerGateway;
        $this->mailer            = $mailer;
    }

    public function handle(TransferMoney $command): void
    {
        $payer = $this->userRepository->findById($command->payer());

        if ($payer instanceof Shopkeeper) {
            throw new UnauthorizedTransferException('Lojistas só recebem transferências, não enviam dinheiro.');
        }

        $wallet = $this->walletRepository->findByUser($payer);

        if ($wallet->balance() <= 0) {
            throw new UnauthorizedTransferException('Não há saldo suficiente para realizar transferência.');
        }

        $this->authorizerGateway->authorize($payer, $command->value());

        $transfer = new Transfer(
            $this->userRepository->findById($command->payee()),
            $payer,
            $command->value()
        );

        $this->transferRepository->persist($transfer);

        $wallet->subBalance($command->value());

        $this->walletRepository->persist($wallet);

        $this->mailer->send(
            [
                'payeeId' => $payer->id(),
                'email'   => $payer->email()
            ]
        );
    }
}

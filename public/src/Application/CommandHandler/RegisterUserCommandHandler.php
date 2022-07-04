<?php
declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RegisterUser;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Model\RegularUser;
use App\Domain\Model\Wallet;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\WalletRepository;

final class RegisterUserCommandHandler
{
    public function __construct(private UserRepository $userRepository, private WalletRepository $walletRepository)
    {
        $this->userRepository   = $userRepository;
        $this->walletRepository = $walletRepository;
    }

    public function handle(RegisterUser $command): void
    {
        $emailAddress = $command->emailAddress();

        if ($this->userRepository->findByEmail($emailAddress)) {
            throw new UserAlreadyExistsException($emailAddress);
        }

        $user = new RegularUser(
            $command->name(),
            $command->cpf(),
            $command->emailAddress(),
            $command->password()
        );

        $wallet = new Wallet($user, 0);

        $this->userRepository->persist($user);
        $this->walletRepository->persist($wallet);
    }
}

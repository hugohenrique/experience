<?php
declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RegisterUser;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;

final class RegisterUserCommandHandler
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterUser $command): void
    {
        $emailAddress = $command->emailAddress();

        if ($this->userRepository->findByEmail($emailAddress)) {
            throw new UserAlreadyExistsException($emailAddress);
        }

        $user = new User(
            $command->name(),
            $command->cpf(),
            $command->emailAddress(),
            $command->password()
        );

        $this->userRepository->persist($user);
    }
}

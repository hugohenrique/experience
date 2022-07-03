<?php
declare(strict_types=1);

namespace App\Application\Service\Validator;

use App\Domain\Repository\UserRepository;
use App\Infrastructure\Validator\Constraint\Cpf;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegisterUserValidator
{
    public function __construct(private ValidatorInterface $validator, private UserRepository $repository)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
    }

    public function validar(array $payload): ConstraintViolationListInterface
    {
        $constraints = new Assert\Collection(
            [
                'allowExtraFields'   => true,
                'allowMissingFields' => true,
                'fields' => [
                    'name' => new Assert\NotBlank(),
                    'cpf' => [
                        new Assert\NotBlank(),
                        new Cpf(),
                        new Assert\Callback(
                            [
                                'callback' => function (string $cpf, ExecutionContextInterface $context) {
                                    if ($this->repository->findByCpf($cpf)) {
                                        $context->addViolation('CPF já está sendo utilizado.');
                                    }
                                }
                            ]
                        )
                    ],
                    'email' => [
                        new Assert\NotBlank(),
                        new Assert\Email([
                            'checkMX'   => true,
                            'checkHost' => true
                        ]),
                        new Assert\Callback(
                            [
                                'callback' => function (string $emailAddress, ExecutionContextInterface $context) {
                                    if ($this->repository->findByEmail($emailAddress)) {
                                        $context->addViolation('Email já está sendo utilizado.');
                                    }
                                }
                            ]
                        )
                    ],
                    'password' => [
                        new Assert\NotBlank(['message' => 'form.not_blank']),
                        new Assert\Length(['min' => 8, 'max' => 16])
                    ]
                ],
            ]
        );

        return $this->validator->validate($payload, $constraints);
    }
}

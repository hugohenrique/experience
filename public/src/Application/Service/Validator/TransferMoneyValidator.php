<?php
declare(strict_types=1);

namespace App\Application\Service\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TransferMoneyValidator
{
    public function __construct(private ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validar(array $payload): ConstraintViolationListInterface
    {
        $constraints = new Assert\Collection(
            [
                'allowExtraFields'   => true,
                'allowMissingFields' => true,
                'fields' => [
                    'payer' => new Assert\NotBlank(),
                    'value' => [
                        new Assert\NotBlank(),
                        new Assert\GreaterThan(0),
                    ]
                ],
            ]
        );

        return $this->validator->validate($payload, $constraints);
    }
}

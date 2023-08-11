<?php

namespace Tenant\Application\SCIM\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Tenant\Application\SCIM\Model\Operation;

/**
 * Class AbstractPatchCommand
 */
abstract class AbstractPatchCommand
{
    /**
     * @var Operation[]
     *
     * @Assert\Valid()
     */
    public array $Operations;

    /**
     * [
     *     "field": [operation, ...],
     *      ...
     * ]
     *
     * @return array
     */
    abstract public function getAllowedOperations(): array;

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function validateOperations(ExecutionContextInterface $context)
    {
        $allowedOperations = $this->getAllowedOperations();

        foreach ($this->Operations as $operation) {
            if (!array_key_exists($operation->path, $allowedOperations)) {
                $context
                    ->buildViolation("The '{$operation->path}' is not available for updating.")
                    ->atPath('operations')
                    ->addViolation();

                continue;
            }

            if (!in_array(mb_strtolower($operation->op), $allowedOperations[$operation->path])) {
                $context
                    ->buildViolation("The '{$operation->path}' does not support '{$operation->op}' operation.")
                    ->atPath('operations')
                    ->addViolation();

                continue;
            }

            if (empty($operation->op)) {
                $context
                    ->buildViolation('The op in Operations is should not be blank')
                    ->atPath('operations')
                    ->addViolation();

                continue;
            }

            if (is_array($operation->value)) {
                foreach ($operation->value as $key => $value) {
                    if (!is_array($value) || !array_key_exists('value', $value)) {
                        $context
                            ->buildViolation('The value is not a valid syntax')
                            ->atPath('value')
                            ->addViolation();

                        continue;
                    }
                }
            }
        }
    }
}

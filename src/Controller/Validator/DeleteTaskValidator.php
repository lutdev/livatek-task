<?php

declare(strict_types=1);

namespace App\Controller\Validator;

class DeleteTaskValidator
{
    /**
     * @param array<string, mixed> $data
     */
    public function validate(array $data): void
    {
        $missedFields = array_diff($this->getRequiredFields(), array_keys($data));

        if ($missedFields !== []) {
            throw new InvalidDataException(\sprintf(
                'Fields `%s` are required',
                implode('`, `', $missedFields),
            ));
        }

        foreach ($this->getNonEmptyFields() as $nonEmptyField) {
            if (isset($data[$nonEmptyField]) && $data[$nonEmptyField] === '') {
                throw new InvalidDataException(\sprintf(
                    '`%s` should not be empty',
                    $nonEmptyField,
                ));
            }
        }
    }

    /**
     * @return string[]
     */
    private function getRequiredFields(): array
    {
        return ['id'];
    }

    /**
     * @return string[]
     */
    private function getNonEmptyFields(): array
    {
        return ['id'];
    }
}
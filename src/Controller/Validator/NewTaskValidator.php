<?php

declare(strict_types=1);

namespace App\Controller\Validator;

use DateTimeImmutable;

class NewTaskValidator
{
    private const DEADLINE_DATE_FORMAT = 'Y-m-d';

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

        if ($data['has_deadline'] === false
            && $data['deadline'] !== null
        ) {
            throw new InvalidDataException('`Deadline` should be NULL because `has_deadline` is "false"');
        }

        if ($data['has_deadline'] === true) {
            $deadlineData = DateTimeImmutable::createFromFormat(self::DEADLINE_DATE_FORMAT, $data['deadline']);

            if ($deadlineData === false) {
                throw new InvalidDataException(
                    '`Deadline` is invalid. Format should be: ' . self::DEADLINE_DATE_FORMAT
                );
            }
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
        return [
            'title', 'description', 'has_deadline', 'deadline', 'author',
        ];
    }

    /**
     * @return string[]
     */
    private function getNonEmptyFields(): array
    {
        return [
            'title', 'description', 'author',
        ];
    }
}
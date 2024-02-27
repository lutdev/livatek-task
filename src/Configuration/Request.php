<?php

declare(strict_types=1);

namespace App\Configuration;

use App\Configuration\Routing\Exceptions\ContentTypeIsInvalidException;
use App\Configuration\Routing\Exceptions\ParamDoesNotExistException;
use App\Configuration\Routing\Exceptions\RequestMethodIsInvalidException;
use InvalidArgumentException;

class Request
{
    public const METHOD_POST = 'post';

    public const METHOD_GET = 'get';

    public const METHOD_DELETE = 'delete';

    private const DEFAULT_POST_CONTENT_TYPE = 'application/json';

    /**
     * @var string[]
     */
    private array $methodMapper = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_DELETE,
    ];

    /**
     * @param string[] $paramsConfig
     *
     * @return array<string, mixed>
     */
    public function fetchParams(array $paramsConfig, string $method = self::METHOD_POST): array
    {
        $result = [];
        foreach ($paramsConfig as $paramName) {
            try {
                $result[$paramName] = $this->fetchParam(
                    $paramName,
                    $method
                );
            } catch (ParamDoesNotExistException) {
                continue;
            }
        }

        return $result;
    }

    public function fetchParam(
        string $paramName,
        string $method = self::METHOD_POST,
    ): mixed {
        if (!\in_array($method, $this->methodMapper, true)) {
            throw new InvalidArgumentException('Invalid method name');
        }

        return match ($method) {
            self::METHOD_GET => $this->findForGet($paramName),
            self::METHOD_POST,
            self::METHOD_DELETE => $this->findForPost($paramName),
            default => throw new RequestMethodIsInvalidException($method),
        };
    }

    private function findForGet(string $paramName): mixed
    {
        $getString = $_SERVER['QUERY_STRING'];
        \parse_str($getString, $getArray);

        return $getArray[$paramName] ?? null;
    }

    private function findForPost(string $paramName): mixed
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? self::DEFAULT_POST_CONTENT_TYPE;

        $params = match ($contentType) {
            ContentTypeEnum::JSON->value => \json_decode(\file_get_contents('php://input'), true, JSON_THROW_ON_ERROR),
            default => throw new ContentTypeIsInvalidException('Content type is not supported'),
        };

        return $params[$paramName] ?? throw new ParamDoesNotExistException($paramName);
    }
}
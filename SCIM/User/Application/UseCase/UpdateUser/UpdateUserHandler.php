<?php

namespace Tenant\Application\SCIM\User\Application\UseCase\UpdateUser;

use Symfony\Component\HttpFoundation\Response;
use Framework\Exception\JsonException;
use Tenant\Application\SCIM\Schema;
use Tenant\Application\SCIM\User\Application\Service\ScimUtility;
use Tenant\Application\User\Domain\UserDomainService;
use Tenant\Application\User\Domain\UserRepositoryInterface;
use Tenant\Component\HandlerDiscovery\AbstractHandler;
use Tenant\Repository\AbstractRepository;

/**
 * Class UpdateUserHandler
 */
class UpdateUserHandler extends AbstractHandler
{
    private UserDomainService $domainService;
    private UserRepositoryInterface $userRepository;

    /**
     * UpdateUserHandler constructor.
     *
     * @param UserDomainService       $domainService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserDomainService $domainService,
        UserRepositoryInterface $userRepository
    ) {
        $this->domainService = $domainService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateUserCommand $updateUserCommand
     *
     * @return UpdateUserResponse
     *
     * @throws JsonException
     */
    public function handle(UpdateUserCommand $updateUserCommand): UpdateUserResponse
    {
        $schemas = $updateUserCommand->schemas;
        if (!is_array($schemas) || (!in_array(Schema::SCHEMA_CORE_USER, $schemas))) {
            throw new JsonException('Invalid Schema syntax');
        }

        $user = $this->userRepository->getById($updateUserCommand->id);

        if ($externalId = trim($updateUserCommand->externalId)) {
            $userByExternalId = $this->userRepository->findOneBy([
                UserRepositoryInterface::FILTER_EXTERNAL_ID => $externalId,
                UserRepositoryInterface::FILTER_DEACTIVATED => AbstractRepository::DEACTIVATED_INCLUDE,
            ]);

            if ($userByExternalId && (string) $userByExternalId->getId() !== (string) $user->getId()) {
                throw new JsonException('This externalId is already used.', Response::HTTP_CONFLICT);
            }
        }

        $data = [
            UserDomainService::PROP_EMAIL => $updateUserCommand->userName,
            UserDomainService::PROP_FIRST_NAME => $updateUserCommand->name->givenName,
            UserDomainService::PROP_LAST_NAME => $updateUserCommand->name->familyName,
        ];

        if ($externalId) {
            $user->setExternalId($externalId);
        }

        $user->setDeactivated(!ScimUtility::convertActiveValueToBool($updateUserCommand->active));

        $this->domainService->update($user, $data);

        $this->userRepository->save($user);

        return new UpdateUserResponse($user);
    }
}

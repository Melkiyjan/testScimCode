<?php

namespace Tenant\Application\SCIM\User\Application\UseCase\GetUser;

use Tenant\Application\User\Domain\UserRepositoryInterface;
use Tenant\Component\HandlerDiscovery\AbstractHandler;
use Tenant\Entity\User;
use Tenant\Repository\AbstractRepository;

/**
 * Class GetUserHandler
 */
class GetUserHandler extends AbstractHandler
{
    private UserRepositoryInterface $userRepository;

    /**
     * GetUserHandler constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param GetUserQuery $getUserQuery
     *
     * @return GetUserResponse
     *
     * @throws
     */
    public function handle(GetUserQuery $getUserQuery): GetUserResponse
    {
        $user = $this->userRepository->getOneBy(
            [
                UserRepositoryInterface::FILTER_ID => $getUserQuery->userId,
                UserRepositoryInterface::FILTER_DEACTIVATED => AbstractRepository::DEACTIVATED_INCLUDE,
                UserRepositoryInterface::FILTER_EXCLUDE_ROLE => [User::ROLE_DEVICE],
            ]
        );

        return new GetUserResponse($user);
    }
}

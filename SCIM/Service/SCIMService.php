<?php

namespace Tenant\Application\SCIM\Service;

use Symfony\Component\HttpFoundation\Response;
use Framework\Exception\JsonException;
use TC;
use Tenant\Application\User\Domain\UserRepositoryInterface;
use Tenant\Entity\User;
use Tenant\Repository\AbstractRepository;

/**
 * Class SCIMService
 */
class SCIMService
{
    private UserRepositoryInterface $userRepository;

    /**
     * SCIMService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $members
     *
     * @return User[]
     *
     * @throws JsonException
     */
    public function findUsersBySCIMMembers(array $members): array
    {
        $SCIMMembersIds = [];
        foreach ($members as $value) {
            $SCIMMembersIds[] = $value['value'];
        }
        $SCIMMembersIds = array_unique($SCIMMembersIds);

        $users = $this->userRepository->findBy(
            [
                UserRepositoryInterface::FILTER_ID => $SCIMMembersIds,
                UserRepositoryInterface::FILTER_DEACTIVATED => AbstractRepository::DEACTIVATED_INCLUDE,
            ]
        );

        $usersById = [];
        foreach ($users as $user) {
            $usersById[(string) $user->getId()] = $user;
        }

        if (count($usersById) !== count($SCIMMembersIds)) {
            throw new JsonException(TC::EXCEPTION_USER_NOT_FOUND, Response::HTTP_NOT_FOUND, ['Ids' => implode(', ', array_diff($SCIMMembersIds, array_keys($usersById)))]);
        }

        return $usersById;
    }
}

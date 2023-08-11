<?php

namespace Tenant\Application\SCIM\User\Application\UseCase\DeleteUser;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Framework\Exception\JsonException;
use TC;
use Tenant\Application\User\Application\Event\SyncUserDeactivatedEvent;
use Tenant\Application\User\Domain\UserDomainService;
use Tenant\Application\User\Domain\UserRepositoryInterface;
use Tenant\Component\HandlerDiscovery\AbstractHandler;
use Tenant\Entity\Calendar;
use Tenant\Entity\User;
use Tenant\Repository\AbstractRepository;
use Tenant\Repository\CalendarRepository;

/**
 * Class DeleteUserHandler
 */
class DeleteUserHandler extends AbstractHandler
{
    private UserDomainService $userDomainService;
    private UserRepositoryInterface $userRepository;
    private CalendarRepository $calendarRepository;
    private EventDispatcherInterface $eventDispatcher;

    /**
     * DeleteUserHandler constructor.
     *
     * @param UserDomainService        $userDomainService
     * @param UserRepositoryInterface  $userRepository
     * @param CalendarRepository       $calendarRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        UserDomainService $userDomainService,
        UserRepositoryInterface $userRepository,
        CalendarRepository $calendarRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userDomainService = $userDomainService;
        $this->userRepository = $userRepository;
        $this->calendarRepository = $calendarRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param DeleteUserCommand $command
     *
     * @return void
     *
     * @throws JsonException
     */
    public function handle(DeleteUserCommand $command): void
    {
        $user = $this->userRepository->getOneBy(
            [
                UserRepositoryInterface::FILTER_DEACTIVATED => AbstractRepository::DEACTIVATED_INCLUDE,
                UserRepositoryInterface::FILTER_ID => $command->userId,
                UserRepositoryInterface::FILTER_ROLE => [User::ROLE_USER],
            ]
        );

        $calendars = $this->calendarRepository->findBy(['user' => $command->userId]);
        $spaceCalendars = array_filter($calendars, static fn (Calendar $calendar) => $calendar->getSpace());
        if ($spaceCalendars) {
            $spaceNames = array_map((static fn (Calendar $calendar) => $calendar->getSpace()->getName()), $spaceCalendars);

            throw new JsonException(TC::EXCEPTION_USER_DELETE_HAS_CALENDARS, Response::HTTP_BAD_REQUEST, [], ['quantity' => count($spaceNames), 'rooms' => implode(', ', $spaceNames)]);
        }

        $this->userRepository->startTransaction();
        $this->userDomainService->delete($user);
        $this->userRepository->remove($user);
        $this->userRepository->commit();
    }
}

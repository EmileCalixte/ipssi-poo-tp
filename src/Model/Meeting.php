<?php
/**
 * Created by PhpStorm.
 * User: Emile
 * Date: 26/06/2019
 * Time: 19:37
 */

namespace Application\Model;


use Application\Exceptions\BadMeetingAttributesException;
use Application\Exceptions\UnableToGenerateMeetingIdException;
use Ramsey\Uuid\Uuid;

class Meeting
{
    const TITLE_MAX_LENGTH = 64;

    const ERROR_TITLE_NAME_TOO_LONG = 'The name of the meeting must contain at most {max_length} characters';
    const ERROR_START_DATE_INVALID_FORMAT = 'Invalid start date format';
    const ERROR_END_DATE_INVALID_FORMAT = 'Invalid end date format';

    private $id;
    private $title;
    private $description;
    private $organizer;
    private $startDate;
    private $endDate;
    private $participants = [];

    public function __construct(string $title, ?string $description, User $organizer, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate, string $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->organizer = $organizer;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return User
     */
    public function getOrganizer(): User
    {
        return $this->organizer;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * @return array
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function addParticipant(User $user)
    {
        $this->participants[] = $user;
    }

    public function generateId(): string
    {
        if ($this->id !== null) {
            throw new UnableToGenerateMeetingIdException('This meeting already have an ID');
        }

        $this->id = Uuid::uuid4()->getHex();

        return $this->id;
    }

    public static function validate(string $title, string $startDate, string $startTime, string $endDate, string $endTime): array
    {
        $errors = [];

        $title = trim($title);

        if (mb_strlen($title) > self::TITLE_MAX_LENGTH) {
            $errors[] = str_replace('{max_length}', self::TITLE_MAX_LENGTH, self::ERROR_TITLE_NAME_TOO_LONG);
        }

        $startDatetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime);
        $endDatetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endTime);

        if (!($startDatetime instanceof \DateTimeImmutable)) {
            $errors[] = self::ERROR_START_DATE_INVALID_FORMAT;
        }

        if (!($endDatetime instanceof  \DateTimeImmutable)) {
            $errors[] = self::ERROR_END_DATE_INVALID_FORMAT;
        }

        return $errors;
    }

    public static function createMeetingFromFormFields(string $title, ?string $description, User $organizer, string $startDate, string $startTime, string $endDate, string $endTime, bool $generateId = true): Meeting
    {
        $title = trim($title);

        $errors = static::validate($title, $startDate, $startTime, $endDate, $endTime);

        if (!empty($errors)) {
            throw new BadMeetingAttributesException('One or several arguments are not valid to create a Meeting. Please use static validate method to validate attributes before generating the meeting');
        }

        $startDatetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime);
        $endDatetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endTime);

        $meeting = new Meeting($title, $description, $organizer, $startDatetime, $endDatetime);

        if ($generateId) {
            $meeting->generateId();
        }

        return $meeting;
    }
}
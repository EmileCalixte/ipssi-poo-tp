<?php


namespace Application\Model;

define("DB_host", "database");
define("DB_name", "demo");
define("DB_user", "demo");
define("DB_password", "demo");

define("DB_TABLE_users", "users");
define("DB_TABLE_meetings", "meetings");
define("DB_TABLE_participants", "participants");


class DAO
{
    private $database;

    function __construct() {
        $this->database = new \PDO('mysql:host='.DB_host.';dbname='.DB_name.';charset=utf8', DB_user, DB_password);
    }

    function saveNewUser(User $user): bool
    {
        $query = $this->database->prepare('INSERT INTO ' . DB_TABLE_users . ' (id, name, email, passwordHash) VALUES (:id, :name, :email, :passwordHash)');
        $query->bindParam(':id', $user->getId());
        $query->bindParam(':name', $user->getName());
        $query->bindParam(':email', $user->getEmail());
        $query->bindParam(':passwordHash', $user->getPasswordHash());
        return $query->execute();
    }

    function saveNewMeeting(Meeting $meeting): bool
    {
        $query = $this->database->prepare('INSERT INTO ' . DB_TABLE_meetings . ' (id, name, description, organizerId, startDate, endDate) VALUES (:id, :name, :description, :organizerId, :startDate, :endDate)');
        $query->bindParam(':id', $meeting->getId());
        $query->bindParam(':name', $meeting->getTitle());
        $query->bindParam(':description', $meeting->getDescription());
        $query->bindParam(':organizerId', $meeting->getOrganizer()->getId());
        $query->bindParam(':startDate', $meeting->getStartDate()->format('Y-m-d H:i:s'));
        $query->bindParam(':endDate', $meeting->getEndDate()->format('Y-m-d H:i:s'));
        return $query->execute();
    }

    function isExistingEmail(string $email): bool
    {
        $query = $this->database->prepare('SELECT COUNT(*) FROM ' . DB_TABLE_users . ' WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        $count = $query->fetch(\PDO::FETCH_NUM)[0];
        if($count > 0) {
            return true;
        }
        return false;
    }

    function getUserByEmail(string $email): User
    {
        $query = $this->database->prepare('SELECT * FROM ' . DB_TABLE_users . ' WHERE email = :email');
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch(\PDO::FETCH_ASSOC);
        return new User($user['name'], $user['email'], $user['passwordHash'], $user['id']);
    }

    function getUserById(string $id): User
    {
        $query = $this->database->prepare('SELECT * FROM ' . DB_TABLE_users . ' WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        $user = $query->fetch(\PDO::FETCH_ASSOC);
        return new User($user['name'], $user['email'], $user['passwordHash'], $user['id']);
    }

    function getMeetings(): array
    {
        $query = $this->database->prepare('SELECT * FROM ' . DB_TABLE_meetings . ' ORDER BY startDate');
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $meetings = [];
        foreach($result as $meeting) {
            $meetings[] = new Meeting(
                $meeting['title'],
                $meeting['description'],
                $this->getUserById($meeting['organizerId']),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $meeting['startDate']),
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $meeting['endDate']),
                $meeting['id']
            );
        }
        return $meetings;
    }

    function getMeetingParticipants(Meeting $meeting): array
    {
        $query = $this->database->prepare('SELECT userId FROM ' . DB_TABLE_participants . ' WHERE meetingId = :meetingId');
        $query->bindParam(':meetingId', $meeting->getId());
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        $participants = [];
        foreach ($result as $participant) {
            $participants[] = $this->getUserById($participant['userId']);
        }
        return $participants;
    }

    function getMeetingById(string $id): ?Meeting
    {
        $query = $this->database->prepare('SELECT * FROM ' . DB_TABLE_meetings . ' WHERE id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if(!$result) {
            return null;
        }
        $meeting = new Meeting(
            $result['title'],
            $result['description'],
            $this->getUserById($result['organizerId']),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['startDate']),
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['endDate']),
            $result['id']
        );

        $participants = $this->getMeetingParticipants($meeting);
        foreach ($participants as $participant) {
            $meeting->addParticipant($participant);
        }

        return $meeting;
    }
}
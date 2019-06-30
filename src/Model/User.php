<?php


namespace Application\Model;


use Application\Exceptions\BadUserAttributesException;
use Application\Exceptions\UnableToGenerateUserIdException;
use Ramsey\Uuid\Uuid;

class User
{
    const NAME_MIN_LENGTH = 3;
    const NAME_MAX_LENGTH = 64;
    const PASSWORD_MIN_LENGTH = 8;

    const ERROR_NAME_TOO_SHORT = 'Your username must contain at least {min_length} characters';
    const ERROR_NAME_TOO_LONG = 'Your username must contain at most {max_length} characters';
    const ERROR_PASSWORD_TOO_SHORT = 'Your password must contain at least {min_length} characters';
    const ERROR_PASSWORD_VALIDATION_DOES_NOT_MATCH = 'The password confirmation must match with the password field';
    const ERROR_INVALID_EMAIL = 'The email address you\'ve entered is not valid';
    const ERROR_EXISTING_EMAIL = 'The email address you\'ve entered is already used';

    private $id;
    private $name;
    private $email;
    private $passwordHash;

    public function __construct(string $name, string $email, string $passwordHash, string $id = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }



    public function generateId(): string
    {
        if ($this->id !== null) {
            throw new UnableToGenerateUserIdException('This user already have an ID');
        }

        $this->id = Uuid::uuid4()->getHex();

        return $this->id;
    }

    public static function validate(string $name, string $email, string $rawPassword, string $rawPasswordConfirm): array
    {
        $dao = new DAO();
        $errors = [];

        $name = trim($name);
        $email = trim(mb_strtolower($email));

        if (mb_strlen($name) < self::NAME_MIN_LENGTH) {
            $errors[] = str_replace('{min_length}', self::NAME_MIN_LENGTH, self::ERROR_NAME_TOO_SHORT);
        }

        if (mb_strlen($name) > self::NAME_MAX_LENGTH) {
            $errors[] = str_replace('{max_length}', self::NAME_MAX_LENGTH, self::ERROR_NAME_TOO_LONG);
        }

        if (mb_strlen($rawPassword) < self::PASSWORD_MIN_LENGTH) {
            $errors[] = str_replace('{min_length}', self::PASSWORD_MIN_LENGTH, self::ERROR_PASSWORD_TOO_SHORT);
        }

        if ($rawPassword !== $rawPasswordConfirm) {
            $errors[] = self::ERROR_PASSWORD_VALIDATION_DOES_NOT_MATCH;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = self::ERROR_INVALID_EMAIL;
        }

        if ($dao->isExistingEmail($email)) {
            $errors[] = self::ERROR_EXISTING_EMAIL;
        }

        return $errors;
    }


    public static function createUserFromFormFields(string $name, string $email, string $rawPassword, string $rawPasswordConfirm, bool $generateId = true): User
    {
        $name = trim($name);
        $email = trim(mb_strtolower($email));

        $errors = static::validate($name, $email, $rawPassword, $rawPasswordConfirm);

        if (!empty($errors)) {
            throw new BadUserAttributesException('One or several arguments are not valid to create a User. Please use static validate method to validate attributes before generating the user');
        }

        $user = new User(trim($name), trim($email), self::getHashedPassword($rawPassword));
        if ($generateId) {
            $user->generateId();
        }

        return $user;
    }

    private static function getHashedPassword(string $rawPassword): string
    {
        return password_hash($rawPassword, PASSWORD_BCRYPT);
    }
}
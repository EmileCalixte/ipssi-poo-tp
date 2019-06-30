<?php

declare(strict_types=1);

namespace Application\Controllers;


use Application\Exceptions\ActionNotFoundException;
use Application\Model\DAO;

class MainController
{
    const ROUTES = [
        // uri => routeName
        '' => 'index',
        'login' => 'login',
        'logout' => 'logout',
        'register' => 'register',
        'create-meeting' => 'createMeeting',
        'view-meetings' => 'viewMeetings',
        'details-meeting' => 'detailsMeeting',
        '404' => '404',
    ];

    public static $currentUser = null;

    private $routeName;

    public function __construct(string $requestUri)
    {
        $dao = new DAO();

        $this->routeName = $this->findRouteByRequestUri($requestUri);

        $actionsController = new ActionsController();

        $actionMethodName = 'action' . ucfirst($this->routeName);

        if (!method_exists($actionsController, $actionMethodName)) {
            throw new ActionNotFoundException('Action not found in ActionsController');
        }

        if(isset($_SESSION['userId'])) {
            static::$currentUser = $dao->getUserById($_SESSION['userId']);
        }

        $actionsController->$actionMethodName();
    }

    public static function login(string $email, string $rawPassword): bool
    {
        $dao = new DAO();
        if (!$dao->isExistingEmail($email)) {
            return false;
        }

        $user = $dao->getUserByEmail($email);

        if (!password_verify($rawPassword, $user->getPasswordHash())) {
            return false;
        }

        $_SESSION['userId'] = $user->getId();

        return true;
    }

    public static function idIsCurrentUser(string $userId): bool {
        if(!is_null(static::$currentUser)) {
            if(static::$currentUser->getId() === $userId) {
                return true;
            }
        }
        return false;
    }

    private function findRouteByRequestUri(string $requestUri): string
    {
        // Remove queryString from route handling
        $requestUri = explode('?', $requestUri)[0];

        // Remove slash before and after the requestUri
        $requestUri = trim($requestUri, '/');

        if (array_key_exists($requestUri, self::ROUTES)) {
            return self::ROUTES[$requestUri];
        }

        return self::ROUTES['404'];
    }
}
<?php


namespace Application\Controllers;


use Application\Exceptions\ViewNotFoundException;
use Application\Model\DAO;
use Application\Model\Meeting;
use Application\Model\User;

class ActionsController
{
    const VIEWS_PATH = __DIR__ . '/../Views/';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionRegister()
    {
        $registered = false;
        $errors = [];

        if ($this->registerFieldsAreInPost()) {
            $errors = User::validate($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password-confirm']);
            if (empty($errors)) {
                $user = User::createUserFromFormFields($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password-confirm']);
                $dao = new DAO();
                $registered = $dao->saveNewUser($user);
            }

        }

        $this->render('register', [
            'registered' => $registered,
            'errors' => $errors
        ]);
    }

    public function actionLogin()
    {
        $logged = false;
        $loginError = false;

        if ($this->loginFieldsAreInPost()) {
            if(MainController::login($_POST['email'], $_POST['password'])) {
                $logged = true;
            } else {
                $loginError = true;
            }
        }

        $this->render('login', [
            'logged' => $logged,
            'loginError' => $loginError
        ]);
    }

    public function actionLogout()
    {
        session_destroy();
        header('location: /');
        die();
    }

    public function actionCreateMeeting()
    {
        //
        $logged = true;
        $meetingCreated = false;
        $errors = [];
        if (is_null(MainController::$currentUser)) {
            $logged = false;
        } else {
            if ($this->createMeetingFieldsAreInPost()) {
                $errors = Meeting::validate($_POST['name'], $_POST['startDate'], $_POST['startTime'], $_POST['endDate'], $_POST['endTime']);
                if(empty($errors)) {
                    $description = $_POST['description'] === '' ? null : $_POST['description'];
                    $meeting = Meeting::createMeetingFromFormFields($_POST['name'], $description, MainController::$currentUser, $_POST['startDate'], $_POST['startTime'], $_POST['endDate'], $_POST['endTime']);
                    $dao = new DAO();
                    $created = $dao->saveNewMeeting($meeting);
                }
            }
        }



        $this->render('create-meeting', [
            'logged' => $logged,
        ]);
    }

    public function actionViewMeetings()
    {
        $dao = new DAO();
        $meetings = $dao->getMeetings();
        $this->render('view-meetings', [
            'meetings' => $meetings
        ]);
    }

    public function actionDetailsMeeting() {
        if(!isset($_GET['id']) || empty($_GET['id'])) {
            header('location: /view-meetings');
            die();
        }

        $dao = new DAO();
        $meeting = $dao->getMeetingById($_GET['id']);

        $this->render('details-meeting', [
            'meeting' => $meeting
        ]);
    }

    public function action404()
    {
        echo "404";
    }

    private function render(string $viewName, array $parameters = [])
    {
        $viewNamePath = self::VIEWS_PATH . $viewName . '.php';
        if (!file_exists($viewNamePath)) {
            throw new ViewNotFoundException('View ' . $viewNamePath . ' not found');
        }

        require($viewNamePath);
    }

    private function registerFieldsAreInPost(): bool
    {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            return false;
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return false;
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            return false;
        }

        if (!isset($_POST['password-confirm']) || empty($_POST['password-confirm'])) {
            return false;
        }

        return true;
    }

    private function loginFieldsAreInPost(): bool
    {
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return false;
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            return false;
        }

        return true;
    }

    private function createMeetingFieldsAreInPost(): bool
    {
        if(!isset($_POST['name']) || empty($_POST['name'])) {
            return false;
        }

        if(!isset($_POST['description'])) {
            return false;
        }

        if(!isset($_POST['startDate']) || empty($_POST['startDate'])) {
            return false;
        }

        if(!isset($_POST['startTime']) || empty($_POST['startTime'])) {
            return false;
        }

        if(!isset($_POST['endDate']) || empty($_POST['endDate'])) {
            return false;
        }

        if(!isset($_POST['endTime']) || empty($_POST['endTime'])) {
            return false;
        }

        return true;
    }
}
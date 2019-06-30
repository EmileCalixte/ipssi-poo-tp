<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?php
    if(is_null($parameters['meeting'])) {
        ?>
        <title>Meeting not found</title>
        <?php
    } else {
        ?>
        <title><?= $parameters['meeting']->getTitle() ?> - Details</title>
        <?php
    }
    ?>
</head>
<body>
    <?php

    if(is_null($parameters['meeting'])) {
        ?>
        <h1>Meeting not found</h1>
        <p><a href="/view-meetings">Back to meetings list</a></p>
        <?php
    } else {
        ?>
        <h1>Details of meeting <?= htmlspecialchars($parameters['meeting']->getTitle()) ?></h1>
        <p><a href="/view-meetings">Back to meetings list</a></p>

        <p>Description: <?= is_null($parameters['meeting']->getDescription()) ? "<i>No description</i>" : $parameters['meeting']->getDescription() ?></p>

        <p>Start date: <?= $parameters['meeting']->getStartDate()->format('Y-m-d H:i:s') ?></p>

        <p>End date: <?= $parameters['meeting']->getEndDate()->format('Y-m-d H:i:s') ?></p>

        <p>Organized by: <?= $parameters['meeting']->getOrganizer()->getName() ?> <?php
            if(\Application\Controllers\MainController::idIsCurrentUser($parameters['meeting']->getOrganizer()->getId())) {
                ?>
                (you)
                <?php
            }
            ?></p>

        <?php
        if (empty($parameters['meeting']->getParticipants())) {
            ?>
            <p>No participants</p>
            <?php
        } else {
            ?>
            <p>Participants:</p>
            <ul>
                <?php
                foreach($parameters['meeting']->getParticipants() as $participant) {
                    ?>
                    <li><?= $participant->getName() ?> <?php
                        if(\Application\Controllers\MainController::idIsCurrentUser($participant->getId())) {
                            ?>
                            (you)
                            <?php
                        }
                        ?></li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>

        <?php
    }
    ?>
</body>
</html>
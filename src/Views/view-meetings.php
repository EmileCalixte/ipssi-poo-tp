<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Meetings</title>
    <style>
        table, th, td {
            border: 1px solid #424242;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h1>Meetings</h1>

    <a href="/">Home</a>

    <a href="/create-meeting">Create a new meeting</a>

    <table>
        <tbody>
        <tr><th>Name</th><th>Description</th><th>Start date</th><th>End date</th><th>Actions</th></tr>
        <?php
        foreach($parameters['meetings'] as $meeting) {
            ?>
            <tr>
                <td><?= htmlspecialchars($meeting->getTitle()) ?></td>
                <td><?= is_null($meeting->getDescription()) ? "<i>No description</i>" : htmlspecialchars($meeting->getDescription()) ?></td>
                <td><?= $meeting->getStartDate()->format('Y-m-d H:i') ?></td>
                <td><?= $meeting->getEndDate()->format('Y-m-d H:i') ?></td>
                <td><a href="/details-meeting?id=<?= $meeting->getId() ?>">View</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</body>
</html>
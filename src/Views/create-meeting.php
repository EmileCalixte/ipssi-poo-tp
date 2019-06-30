<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Create a meeting</title>
</head>
<body>
    <h1>Create a meeting</h1>
    <?php
        if($parameters['logged']) {
            ?>
            <a href="/">Home</a>

            <p><strong>INFO : La création de meeting ne fonctionne pas</strong></p>

            <p>Fill out the fields to create your meeting.</p>

            <form id="create-meeting-form" action="/create-meeting" method="post">
                <label for="input-name">Meeting name</label>
                <input type="text" id="input-name" name="name" required><br>

                <label for="textarea-description">Description (optional)</label>
                <textarea id="textarea-description" name="description"></textarea><br>

                <label for="input-startDate">Start date</label>
                <input type="date" id="input-startDate" name="startDate" required>
                <input type="time" id="input-startTime" name="startTime" required><br>

                <label for="input-endDate">End date</label>
                <input type="date" id="input-endDate" name="endDate" required>
                <input type="time" id="input-endTime" name="endTime" required><br>

                <button type="submit">Create meeting</button>
            </form>
            <?php
        } else {
            ?>
            <p>You have to <a href="/login">login</a> to create a meeting.</p>
            <?php
        }
    ?>
</body>
</html>
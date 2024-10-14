<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Query Executor</title>
</head>
<body>

    <h1>Execute SQL Query</h1>

    <?php if (!empty($error)): ?>
        <div style="color: red;">
            <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label for="query">Enter SQL Query:</label><br>
        <textarea name="query" id="query" rows="6" cols="80"><?php echo htmlspecialchars($query); ?></textarea><br><br>
        <button type="submit">Execute</button>
    </form>

    <hr>
    <?php if (!empty($results)): ?>
        <h2>Query Results:</h2>
        <?php if (is_array($results)): ?>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <?php if (!empty($results[0])): ?>
                            <?php foreach (array_keys($results[0]) as $column): ?>
                                <th><?php echo htmlspecialchars($column); ?></th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><?php echo htmlspecialchars($results['Affected Rows']) . " rows affected."; ?></p>
        <?php endif; ?>

    <?php endif; ?>

</body>
</html>
<?php require dirname(__DIR__). '/templates/header.php'; ?>


<div class=""> <!-- class="container" quand je mets container, mon footer bug-->
    <h1>La Bouzinerie</h1>
    <?php require dirname(__DIR__). '/templates/content.php'; ?>
    <section id="leaderboard">
        <h2>Classement</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Email</th>
                    <th>Score</th>
                    <th>Total Questions</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($leaderboard)): ?>
                    <?php foreach ($leaderboard as $index => $entry): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($entry['email']) ?></td>
                            <td><?= htmlspecialchars($entry['score']) ?></td>
                            <td><?= htmlspecialchars($entry['total_questions']) ?></td>
                            <td><?= htmlspecialchars($entry['played_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No scores available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>


<?php require dirname(__DIR__). '/templates/footer.php'; ?>


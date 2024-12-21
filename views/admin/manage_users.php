<?php require dirname(__DIR__) . '/templates/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Gestion des utilisateurs</h2>

    <div class="row mt-4">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Date de création</th>
                        <th>Scores</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['is_admin'] ? 'Oui' : 'Non'; ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <?php if (!empty($user['scores'])): ?>
                                    <ul>
                                        <?php foreach ($user['scores'] as $score): ?>
                                            <li>
                                                Score: <?php echo $score['score']; ?> /
                                                <?php echo $score['total_questions']; ?>
                                                (<?php echo htmlspecialchars($score['played_at']); ?>)
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    Aucun score
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?page=admin&action=users&manage=edit_user&id=<?php echo $user['id']; ?>" 
                                class="btn btn-sm btn-warning">Modifier</a>
                                <a href="index.php?page=admin&action=users&manage=delete_user&id=<?php echo $user['id']; ?>" 
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?');">
                                    Supprimer
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


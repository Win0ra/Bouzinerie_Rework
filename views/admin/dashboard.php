<?php require dirname(__DIR__).'/templates/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Tableau de bord administrateur</h2>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Questions</h5>
                    <a href="index.php?page=admin&action=add_question" class="btn btn-primary">Ajouter une question</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $question): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($question['id']); ?></td>
                                <td><?php echo htmlspecialchars($question['question']); ?></td>
                                <td><?php
                                    foreach ($categories as $category) {
                                        if ($category['id'] == $question['category_id']) {
                                            echo htmlspecialchars($category['name']);
                                            break;
                                        }
                                    }
                                ?></td>
                                <td>
                                    <a href="index.php?page=admin&action=edit_question&id=<?php echo $question['id']; ?>" 
                                       class="btn btn-sm btn-warning">Modifier</a>
                                    <form method="POST" action="index.php?page=admin&action=delete_question&id=<?php echo $question['id']; ?>" 
                                          class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question?');">
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Gestion des catégories</h5>
                </div>
                <div class="card-body">
                    <a href="index.php?page=admin&action=categories" class="btn btn-primary">Gérer les catégories</a>
                </div>
            </div>
        </div>
    </div>
</div>
```

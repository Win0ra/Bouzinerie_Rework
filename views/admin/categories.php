<?php 
require_once __DIR__ . '/../../models/Category.php';

// Initialisation des variables
$errors = [];
$success = '';



require dirname(__DIR__).'/templates/admin/header.php';
?>

<div class="container mt-4">
    <h2>Gestion des catégories</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Ajouter une catégorie</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="form-group mb-3">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Catégories existantes</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['id']) ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= htmlspecialchars($category['description']) ?></td>
                        <td>
                            <?php if (!empty($category['image'])): ?>
                                <img src="/views/uploads/categories/<?= basename($category['image']) ?>" alt="Image de catégorie" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" onclick="editCategory(<?= htmlspecialchars(json_encode($category)) ?>)">Modifier</button>
                            <form method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['id']) ?>">
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

<script>
function editCategory(category) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="category_id" value="${category.id}">
        <div class="form-group mb-3">
            <label for="edit_name">Nom</label>
            <input type="text" class="form-control" id="edit_name" name="name" 
                value="${category.name}" required>
        </div>
        <div class="form-group mb-3">
            <label for="edit_description">Description</label>
            <textarea class="form-control" id="edit_description" name="description">${category.description || ''}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="edit_image">Image</label>
            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
            ${
                category.image 
                ? `<img src="/views/uploads/categories/<?= basename($category['image']) ?>" alt="Current Image" width="100" class="mt-2">` 
                : ''
            }
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Annuler</button>
    `;

    const container = document.querySelector('.container');
    container.innerHTML = '<h2>Modifier la catégorie</h2>';
    container.appendChild(form);
}

function cancelEdit() {
    window.location.reload();
}
</script>

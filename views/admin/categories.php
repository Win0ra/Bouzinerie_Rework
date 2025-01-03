<?php 
require_once __DIR__ . '/../../models/Category.php';

// Initialisation des variables
$errors = [];
$success = '';

try {
    $categoryObj = new Category();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'add':
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $image = $_FILES['image'] ?? null;

                if (empty($name)) {
                    $errors[] = "Le nom est requis";
                } else {
                    $imagePath = null;

                    if ($image && $image['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = dirname(__DIR__) . '/uploads/categories/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $imagePath = $uploadDir . basename($image['name']);
                        move_uploaded_file($image['tmp_name'], $imagePath);
                    }

                    if ($categoryObj->create($name, $description, $imagePath)) {
                        $success = "La catégorie a été ajoutée avec succès";
                    } else {
                        $errors[] = "Une erreur s'est produite lors de l'ajout de la catégorie";
                    }
                }
                break;

            case 'edit':
                $id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $image = $_FILES['image'] ?? null;

                if (!$id) {
                    $errors[] = "ID de catégorie invalide";
                } elseif (empty($name)) {
                    $errors[] = "Le nom est requis";
                } else {
                    $imagePath = null;

                    if ($image && $image['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = dirname(__DIR__) . '/uploads/categories/';
                        
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        $imagePath = $uploadDir . basename($image['name']);
                        move_uploaded_file($image['tmp_name'], $imagePath);
                    }

                    if ($categoryObj->update($id, $name, $description, $imagePath)) {
                        $success = "La catégorie a été mise à jour avec succès";
                    } else {
                        $errors[] = "Une erreur s'est produite lors de la mise à jour de la catégorie";
                    }
                }
                break;

            case 'delete':
                $id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);

                if (!$id) {
                    $errors[] = "ID de catégorie invalide";
                } elseif ($categoryObj->delete($id)) {
                    $success = "La catégorie a été supprimée avec succès";
                }
                break;
        }
    }

    $categories = $categoryObj->getAll();

} catch (Exception $e) {
    $errors[] = "Une erreur s'est produite : " . $e->getMessage();
    $categories = [];
}

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
                                <img src="/uploads/categories/<?= basename($category['image']) ?>" alt="Image de catégorie" width="50">
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
                ? `<img src="/uploads/categories/${encodeURIComponent(category.image)}" alt="Current Image" width="100" class="mt-2">` 
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

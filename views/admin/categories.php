<?php
// Inclusion du modèle Category pour gérer les opérations liées aux catégories
require_once __DIR__ . '/../../models/Category.php';

// Initialisation des variables pour gérer les erreurs et les messages de succès
$errors = []; // Tableau pour stocker les messages d'erreur
$success = ''; // Message de succès

// Inclusion de l'en-tête d'administration
require dirname(__DIR__) . '/templates/admin/header.php';
?>

<!-- Conteneur principal -->
<div class="container mt-4">
    <h2>Gestion des catégories</h2>

    <!-- Affiche les erreurs si elles existent -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li> <!-- Sécurise l'affichage des erreurs -->
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Affiche un message de succès si présent -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?> <!-- Sécurise l'affichage du message -->
        </div>
    <?php endif; ?>

    <!-- Formulaire pour ajouter une nouvelle catégorie -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Ajouter une catégorie</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add"> <!-- Action pour l'ajout -->
                <div class="form-group mb-3">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" required> <!-- Champ requis -->
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*"> <!-- Champ pour uploader une image -->
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Liste des catégories existantes -->
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
                    <?php foreach ($categories as $category): ?> <!-- Parcours des catégories -->
                    <tr>
                        <td><?= htmlspecialchars($category['id']) ?></td> <!-- Affiche l'ID -->
                        <td><?= htmlspecialchars($category['name']) ?></td> <!-- Affiche le nom -->
                        <td><?= htmlspecialchars($category['description']) ?></td> <!-- Affiche la description -->
                        <td>
                            <!-- Affiche l'image si elle existe -->
                            <?php if (!empty($category['image'])): ?>
                                <img src="/views/uploads/categories/<?= $category['image'] ?>" alt="Image de catégorie" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Bouton pour modifier la catégorie -->
                            <button type="button" class="btn btn-sm btn-warning" onclick="editCategory(<?= htmlspecialchars(json_encode($category)) ?>)">Modifier</button>
                            
                            <!-- Formulaire pour supprimer la catégorie -->
                            <form method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?');">
                                <input type="hidden" name="action" value="delete"> <!-- Action pour suppression -->
                                <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['id']) ?>"> <!-- ID de la catégorie -->
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

<!-- Script pour gérer la modification d'une catégorie -->
<script>
function editCategory(category) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.enctype = 'multipart/form-data';  
    form.innerHTML = `
        <input type="hidden" name="action" value="edit"> <!-- Action pour la modification -->
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
                ? `<img src="/views/uploads/categories/${category.image}" alt="Image actuelle" width="100" class="mt-2">` 
                : ''
            }
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Annuler</button>
    `;

    // Remplace le contenu de la page par le formulaire de modification
    const container = document.querySelector('.container');
    container.innerHTML = '<h2>Modifier la catégorie</h2>';
    container.appendChild(form);
}

function cancelEdit() {
    // Recharge la page pour annuler les modifications
    window.location.reload();
}
</script>

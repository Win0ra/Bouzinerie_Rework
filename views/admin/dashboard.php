<?php 
require dirname(__DIR__) . '/templates/admin/header.php'; // Inclusion de l'en-tête pour l'administration

// Initialisation des variables $questions et $categories si elles ne sont pas définies
$questions = $questions ?? [];
$categories = $categories ?? [];
?>

<!-- Conteneur principal -->
<div class="container mt-4">
    <h2>Tableau de bord administrateur</h2> <!-- Titre de la page -->

    <!-- Section pour la gestion des questions -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <!-- En-tête de la carte contenant le titre et le bouton d'ajout -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Questions</h5>
                    <a href="index.php?page=admin&action=add_question" class="btn btn-primary">Ajouter une question</a> <!-- Lien pour ajouter une nouvelle question -->
                </div>
                <div class="card-body">
                    <!-- Vérifie si des questions existent -->
                    <?php if (!empty($questions)): ?>
                        <!-- Table pour afficher les questions -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th> <!-- Colonne pour l'ID de la question -->
                                    <th>Question</th> <!-- Colonne pour le texte de la question -->
                                    <th>Catégorie</th> <!-- Colonne pour la catégorie associée -->
                                    <th>Actions</th> <!-- Colonne pour les actions (modifier/supprimer) -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Parcourt les questions pour les afficher -->
                                <?php foreach ($questions as $question): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($question['id']); ?></td> <!-- Affiche l'ID de la question -->
                                        <td><?php echo htmlspecialchars($question['question']); ?></td> <!-- Affiche le texte de la question -->
                                        <td>
                                            <!-- Recherche et affiche le nom de la catégorie associée -->
                                            <?php
                                            foreach ($categories as $category) {
                                                if ($category['id'] == $question['category_id']) {
                                                    echo htmlspecialchars($category['name']); // Affiche le nom de la catégorie
                                                    break; // Arrête la recherche une fois la catégorie trouvée
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <!-- Lien pour modifier la question -->
                                            <a href="index.php?page=admin&action=edit_question&id=<?php echo $question['id']; ?>" 
                                                class="btn btn-sm btn-warning">Modifier</a>
                                            
                                            <!-- Formulaire pour supprimer la question -->
                                            <form method="POST" action="index.php?page=admin&action=delete_question&id=<?php echo $question['id']; ?>" 
                                                class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question?');">
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button> <!-- Bouton pour supprimer -->
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <!-- Message affiché si aucune question n'est disponible -->
                        <p>Aucune question disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

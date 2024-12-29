<?php require dirname(__DIR__) . '/templates/admin/header.php'; ?>

<div class="container mt-4">
    <h2><?php echo isset($question) ? 'Modifier' : 'Ajouter'; ?> une question</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group mb-3">
            <label for="question">Question</label>
            <input type="text" class="form-control" id="question" name="question"
                value="<?php echo isset($question) ? htmlspecialchars($question['question']) : ''; ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Réponses</label>
            <?php
            $answers = isset($question['answers']) && is_string($question['answers'])
                ? json_decode($question['answers'], true)
                : null;

            // Si $answers n'est pas un tableau, on initialise avec des réponses vides par défaut
            if (!is_array($answers)) {
                $answers = ['', '', '', ''];
            }
            ?>

            <div class="form-group mb-3">
                <label>Réponses</label>
                <?php foreach ($answers as $index => $answer): ?>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="answers[]"
                            value="<?php echo htmlspecialchars($answer); ?>" required>
                    </div>
                <?php endforeach; ?>
            </div>



            <div class="form-group mb-3">
                <label for="correct_answer">Bonne réponse (0-3)</label>
                <input type="number" class="form-control" id="correct_answer" name="correct_answer"
                    value="<?php echo isset($question) ? $question['correct_answer'] : ''; ?>"
                    min="0" max="3" required>
            </div>

            <div class="form-group mb-3">
                <label for="category">Catégorie</label>
                <select class="form-control" id="category" name="category_id" required>
                    <option value="">Sélectionner une catégorie</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"
                            <?php echo (isset($question) && $question['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <?php echo isset($question) ? 'Mettre à jour' : 'Ajouter'; ?>
            </button>
            <a href="index.php?page=admin" class="btn btn-secondary">Retour</a>
    </form>
</div>
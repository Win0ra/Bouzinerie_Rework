<?php require dirname(__DIR__) . '/templates/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Modifier l'utilisateur</h2>

    <form method="POST" action="">
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_admin" class="form-check-input" id="is_admin"
                   <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_admin">Admin</label>
        </div>

        <div class="form-group mb-3">
            <label for="password">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index.php?page=admin&action=users" class="btn btn-secondary">Annuler</a>
    </form>
</div>


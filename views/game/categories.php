<?php require dirname(__DIR__). '/templates/header.php'; ?>
<link rel="stylesheet" href="/public/css/styles-body.css" type="text/css" media="all">

<div class="container mt-4">
    <h2 class="text-center mb-4">Choisissez une catégorie</h2>
    
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                        <a href="index.php?page=quiz&category=<?php echo $category['id']; ?>" 
                        class="btn btn-primary">
                            Commencer le quiz
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require dirname(__DIR__). '/templates/footer.php'; ?>
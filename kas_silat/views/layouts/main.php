<?php include 'views/layouts/header.php'; ?>
<?php include 'views/layouts/sidebar.php'; ?>
<?php include 'views/layouts/navbar.php'; ?>

<!-- Flash Messages -->
<?php if ($flash = $this->getFlash()): ?>
    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : $flash['type'] ?> alert-dismissible fade show" role="alert">
        <?= $flash['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Content -->
<?php 
if (isset($content)) {
    $this->view($content, $content_data ?? []);
}
?>

<?php include 'views/layouts/footer.php'; ?>
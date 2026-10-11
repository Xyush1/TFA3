<?= view('templates/header', ['title' => $title]) ?>

<main class="container">
    <h1>New User</h1>

    <?php $validation = session()->getFlashdata('validation'); ?>

    <?php if ($validation): ?>
        <div class="errors">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form
        action="<?= site_url('users/create') ?>"
        method="post"
    >
        <?= csrf_field() ?>

        <div>
            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc(old('username')) ?>"
                required
            >
        </div>

        <div>
            <label for="full_name">Full Name</label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= esc(old('full_name')) ?>"
                required
            >
        </div>

        <button type="submit">Save User</button>

        <a href="<?= site_url('users') ?>">
            Cancel
        </a>
    </form>
</main>

<?= view('templates/footer') ?>
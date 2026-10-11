<?= view('templates/header', ['title' => $title]) ?>

<main class="container">
    <h1>New Customer</h1>

    <?php $validation = session()->getFlashdata('validation'); ?>

    <?php if ($validation): ?>
        <div class="errors">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form
        action="<?= site_url('customers/create') ?>"
        method="post"
    >
        <?= csrf_field() ?>

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

        <div>
            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc(old('email')) ?>"
                required
            >
        </div>

        <div>
            <label for="phone">Phone Number</label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="<?= esc(old('phone')) ?>"
            >
        </div>

        <button type="submit">Save Customer</button>

        <a href="<?= site_url('customers') ?>">
            Cancel
        </a>
    </form>
</main>

<?= view('templates/footer') ?>
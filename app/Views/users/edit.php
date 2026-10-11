<?= view('templates/header', ['title' => $title]) ?>

<main class="container">
    <h1>Edit User</h1>

    <?php $validation = session()->getFlashdata('validation'); ?>

    <?php if ($validation): ?>
        <div class="errors">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <?php
        $currentAvatar = ! empty($user['avatar'])
            ? basename($user['avatar'])
            : 'default-avatar.png';
    ?>

    <p>Current Avatar</p>

    <img
        src="<?= base_url('uploads/avatars/' . $currentAvatar) ?>"
        alt="<?= esc($user['full_name']) ?>"
        width="100"
        height="100"
        style="object-fit: cover; border-radius: 50%;"
    >

    <form
        action="<?= site_url('users/update/' . $user['id']) ?>"
        method="post"
        enctype="multipart/form-data"
    >
        <?= csrf_field() ?>

        <div>
            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc(
                    old('username', $user['username'])
                ) ?>"
                required
            >
        </div>

        <div>
            <label for="full_name">Full Name</label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= esc(
                    old('full_name', $user['full_name'])
                ) ?>"
                required
            >
        </div>

        <div>
            <label for="avatar">Profile Picture</label>

            <input
                type="file"
                id="avatar"
                name="avatar"
                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
            >

            <p>
                JPG or PNG only. Maximum file size: 2 MB.
            </p>
        </div>

        <button type="submit">Update User</button>

        <a href="<?= site_url('users') ?>">
            Cancel
        </a>
    </form>
</main>

<?= view('templates/footer') ?>
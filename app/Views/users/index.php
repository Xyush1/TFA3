<?= view('templates/header', ['title' => $title]) ?>

<main class="container">
    <h1>User Accounts</h1>

    <p>
        This page displays user and staff records retrieved from the MySQL
        database.
    </p>

    <p>
        <a href="<?= site_url('users/new') ?>">Add New User</a>
    </p>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($users)): ?>
        <p>No user accounts were found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php
                        $avatar = ! empty($user['avatar'])
                            ? basename($user['avatar'])
                            : 'default-avatar.png';
                    ?>

                    <tr>
                        <td>
                            <img
                                src="<?= base_url(
                                    'uploads/avatars/' . $avatar
                                ) ?>"
                                alt="<?= esc($user['full_name']) ?>"
                                width="60"
                                height="60"
                                style="
                                    object-fit: cover;
                                    border-radius: 50%;
                                "
                            >
                        </td>

                        <td><?= esc($user['username']) ?></td>

                        <td><?= esc($user['full_name']) ?></td>

                        <td>
                            <?= esc($user['created_at'] ?? '') ?>
                        </td>

                        <td>
                            <a href="<?= site_url(
                                'users/edit/' . $user['id']
                            ) ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?= view('templates/footer') ?>
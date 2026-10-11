<?= view('templates/header', ['title' => $title]) ?>

<main class="container">
    <h1>Customer Accounts</h1>

    <p>
        This page displays customer records retrieved from the MySQL database.
    </p>

    <p>
        <a href="<?= site_url('customers/new') ?>">Add New Customer</a>
    </p>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($customers)): ?>
        <p>No customer accounts were found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= esc($customer['full_name']) ?></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone'] ?? '') ?></td>
                        <td>
                            <a href="<?= site_url(
                                'customers/edit/' . $customer['id']
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
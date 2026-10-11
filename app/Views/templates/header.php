<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?></title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #222;
        }

        nav {
            background-color: #1f2937;
            padding: 16px 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 24px;
            font-weight: bold;
        }

        nav a:hover {
            color: #60a5fa;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.10);
        }

        h1 {
            margin-top: 0;
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            color: #555;
        }
    </style>
</head>

<body>
    <nav>
        <a href="<?= site_url('/') ?>">Home</a>
        <a href="<?= site_url('about') ?>">About</a>
        <a href="<?= site_url('customers') ?>">Customer Accounts</a>
        <a href="<?= site_url('users') ?>">User Accounts</a>
    </nav>
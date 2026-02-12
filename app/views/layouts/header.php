<?php
$base = \Flight::get('flight.base_url');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mailbox</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= $base ?>adminlte/dist/css/adminlte.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    <nav class="app-header navbar navbar-expand bg-body">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="fa-solid fa-bars"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a href="<?= $base ?>messages" class="nav-link">Inbox</a>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="<?= $base ?>messages/compose" class="nav-link" title="Compose">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <div class="sidebar-brand">
        <a href="<?= $base ?>messages" class="brand-link">
          <span class="brand-text fw-light">Mailbox</span>
        </a>
      </div>

      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <ul class="nav sidebar-menu flex-column" role="menu">
            <li class="nav-item">
              <a href="<?= $base ?>messages" class="nav-link">
                <i class="nav-icon fa-solid fa-inbox"></i>
                <p>Inbox</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base ?>messages/compose" class="nav-link">
                <i class="nav-icon fa-solid fa-pen-to-square"></i>
                <p>Compose</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= $base ?>login" class="nav-link">
                <i class="nav-icon fas fa-sign-in-alt"></i>
                <p>Login</p>
              </a>
            </li>

          </ul>
        </nav>
      </div>
    </aside>

    <main class="app-main">
      <div class="app-content p-3">
        <div class="container-fluid">
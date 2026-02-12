<?php require __DIR__ . '/layouts/header.php'; ?>
<?php $base = \Flight::get('flight.base_url'); ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-4">

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Login</h3>
        </div>

        <form method="post" action="<?= $base ?>login">
          <div class="card-body">

            <div class="form-group">
              <label>Choisir un utilisateur</label>
              <select name="user_id" class="form-control" required>
                <option value="1">admin</option>
                <option value="2">user1</option>
                <option value="3">user2</option>
              </select>
            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-block">
              Login
            </button>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>

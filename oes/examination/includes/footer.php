    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

<!-- Logout Modal -->
  <div class="modal fade" id="logoutModal01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="logout.php" method="POST">
          <div class="text-center">Select "<span style="color: red;">Logout</span>" below to end your current session.</div>
        <div class="modal-footer">
          <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>
          <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>
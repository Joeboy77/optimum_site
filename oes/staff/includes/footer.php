    
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- include jquery cdn -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    
    <!-- js bootstrap 5 dataTables with fundawebit -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
      $(function(){
        var tableEl = $('#example');
        if (tableEl.length) {
          var selector = '#example';
          if ($.fn.DataTable.isDataTable(selector)) {
            $(selector).DataTable().clear().destroy();
          }
          tableEl.DataTable({
            paging: true,
            searching: true,
            ordering: true,
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [[1, 'asc']],
            columnDefs: [
              { targets: 'no-sort', orderable: false }
            ],
            responsive: true,
            autoWidth: false,
            deferRender: true
          });
        }
      });
    </script>
    
  </body>
</html>

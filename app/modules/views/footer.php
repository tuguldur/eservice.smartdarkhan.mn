<footer class="page-footer pt-0 lr-page">
    <!-- Copyright -->
    <div class="footer-copyright">
        <div class="dashboard-body pt-0 text-center">
            <div class="container-fluid">
                <strong>&copy;</strong> ESERVICE DARKHAN | Developed by ERDSYSTEM Co.,ltd
            </div>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<?php include APPPATH . '/modules/views/js.php'; ?>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2],
                    className: 'mdl-data-table__cell--non-numeric'
                }
            ]
        });
    });
</script>
<?php //include APPPATH . '/modules/views/notification_message.php'; ?>
</body>
</html>
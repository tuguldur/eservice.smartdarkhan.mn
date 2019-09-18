<footer class="page-footer pt-0 lr-page">
    <!-- Copyright -->
    <div class="footer-copyright">
        <div class="dashboard-body pt-0 text-center">
            <div class="container-fluid">
            © ESERVICE DARKHAN | Developed by ERD SYSTEM Co.,ltd
            </div>
        </div>
    </div>
    <!-- Copyright -->
</footer>
<?php include APPPATH . '/modules/views/admin_js.php'; ?>
<?php
$file = dirname(BASEPATH) . "/install/";
if (is_dir($file)) {
    ?>
    <script>
        toastr.error('<?php echo $this->lang->line('delete_install'); ?>');
    </script>
<?php } ?>
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
</body>
</html>
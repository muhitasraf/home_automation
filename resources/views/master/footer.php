    <script src="https://getbootstrap.com/docs/4.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo asset('js/toastr.min.js')?>"></script>

    <script type="text/javascript">
        
        $(document).ready(function() {

            // Set the options that I want
            let $type = "<?php echo session('notification_type'); ?>";
            let $message = "<?php echo session('notification_message'); ?>";
            
            if($type != null){
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                switch($type){
                    case 'info':
                        toastr.info($message);
                        break;
                    case 'warning':
                        toastr.warning($message);
                        break;
                    case 'success':
                        toastr.success($message);
                        break;
                    case 'error':
                        toastr.error($message);
                        break;
                }
            }
        });
        
    </script>
    <?php
       //unset notification sessions
       session('notification_type','');
       session('notification_message','');
    ?>
</body>

</html>
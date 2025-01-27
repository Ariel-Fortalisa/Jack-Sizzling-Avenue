<script>
<?php if (isset($_SESSION['success_message'])): ?>
    swal({
        title: "Success!",
        text: "<?= $_SESSION['success_message'] ?>",
        icon: "success",
        button: {
            text: "OK",
            className: "custom-ok-button"
        }
    });
    <?php unset($_SESSION['success_message']); ?>
<?php elseif (isset($_SESSION['error_message'])): ?>
    swal({
        title: "Something went Wrong!",
        text: "<?= $_SESSION['error_message'] ?>",
        icon: "error",
        button: {
            text: "OK",
            className: "custom-error-button"
        }
    });
    <?php unset($_SESSION['error_message']); ?>
<?php elseif (isset($_SESSION['warning_message'])): ?>
    swal({
        title: "Warning!",
        text: "<?= $_SESSION['warning_message'] ?>",
        icon: "warning",
        button: {
            text: "OK",
            className: "custom-warning-button"
        }
    });
    <?php unset($_SESSION['warning_message']); ?>
<?php endif; ?>
</script>

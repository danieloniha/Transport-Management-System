<!-- Script for sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php
    
    if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
        ?>
        <script>
        Swal.fire({
            icon: "<?php echo $_SESSION['status_code']; ?>",
            title: "<?php echo $_SESSION['status']; ?>",
            // text: 'Something went wrong!',
            // footer: '<a href="">Why do I have this issue?</a>'
        });
</script>
        <?php  
        unset($_SESSION['status']);
    }
?>
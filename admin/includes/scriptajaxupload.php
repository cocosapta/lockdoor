<script> //Upload Foto Update Profil
    $(document).ready(function() {
        $("#simpanEditProfile").click(function() {
            const uploadImage = $('#inputFotoFile01').prop('files')[0];

            let formData = new FormData();
            formData.append('uploadImage', uploadImage);
            // formData.append('nama_file', $('#nama_file').val());

            $.ajax({
                type: 'POST',
                headers: {
                    "Token":"<?php echo $baseKeyApi ?>"
                },
                url: "<?php echo $baseUrlApi ?>"+"profil-image",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(msg) {
                    // alert(msg);
                    Toast.fire({
                    type: 'success',
                    title: msg
                    })
                    document.getElementById("form-data").reset();
                },
                error: function() {
                    // alert("Data Gagal Diupload");
                    Toast.fire({
                    type: 'error',
                    title: '  Foto gagal diunggah'
                    })
                }
            });
        });
    });
</script>

<script> //Upload Foto Add Account
    $(document).ready(function() {
        $("#simpanTambahAkun").click(function() {
            const uploadImage = $('#inputFotoFile04').prop('files')[0];

            let formData = new FormData();
            formData.append('uploadImage', uploadImage);
            // formData.append('nama_file', $('#nama_file').val());

            $.ajax({
                type: 'POST',
                headers: {
                    "Token":"<?php echo $baseKeyApi ?>"
                },
                url: "<?php echo $baseUrlApi ?>"+"profil-image",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(msg) {
                    // alert(msg);
                    Toast.fire({
                    type: 'success',
                    title: msg
                    })
                    document.getElementById("form-data").reset();
                },
                error: function() {
                    // alert("Data Gagal Diupload");
                    Toast.fire({
                    type: 'error',
                    title: '  Foto gagal diunggah'
                    })
                }
            });
        });
    });
</script>

<script> //Upload Foto Edit Account
    $(document).ready(function() {
        $("#simpanEditAkun").click(function() {
            const uploadImage = $('#inputFotoFile05').prop('files')[0];

            let formData = new FormData();
            formData.append('uploadImage', uploadImage);
            // formData.append('nama_file', $('#nama_file').val());

            $.ajax({
                type: 'POST',
                headers: {
                    "Token":"<?php echo $baseKeyApi ?>"
                },
                url: "<?php echo $baseUrlApi ?>"+"profil-image",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(msg) {
                    // alert(msg);
                    Toast.fire({
                    type: 'success',
                    title: msg
                    })
                    document.getElementById("form-data").reset();
                },
                error: function() {
                    // alert("Data Gagal Diupload");
                    Toast.fire({
                    type: 'error',
                    title: '  Foto gagal diunggah'
                    })
                }
            });
        });
    });
</script>

<script> //Upload Foto Add User
    $(document).ready(function() {
        $("#simpanTambahPengguna").click(function() {
            const uploadImage = $('#inputFotoFile03').prop('files')[0];

            let formData = new FormData();
            formData.append('uploadImage', uploadImage);
            // formData.append('nama_file', $('#nama_file').val());

            $.ajax({
                type: 'POST',
                headers: {
                    "Token":"<?php echo $baseKeyApi ?>"
                },
                url: "<?php echo $baseUrlApi ?>"+"profil-image",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(msg) {
                    // alert(msg);
                    Toast.fire({
                    type: 'success',
                    title: msg
                    })
                    document.getElementById("form-data").reset();
                },
                error: function() {
                    // alert("Data Gagal Diupload");
                    Toast.fire({
                    type: 'error',
                    title: '  Foto gagal diunggah'
                    })
                }
            });
        });
    });
</script>
<script> //Upload Foto Edit User
    $(document).ready(function() {
        $("#simpanEditUser").click(function() {
            const uploadImage = $('#inputFotoFile02').prop('files')[0];

            let formData = new FormData();
            formData.append('uploadImage', uploadImage);
            // formData.append('nama_file', $('#nama_file').val());

            $.ajax({
                type: 'POST',
                headers: {
                    "Token":"<?php echo $baseKeyApi ?>"
                },
                url: "<?php echo $baseUrlApi ?>"+"profil-image",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(msg) {
                    // alert(msg);
                    Toast.fire({
                    type: 'success',
                    title: msg
                    })
                    document.getElementById("form-data").reset();
                },
                error: function() {
                    // alert("Data Gagal Diupload");
                    Toast.fire({
                    type: 'error',
                    title: '  Foto gagal diunggah'
                    })
                }
            });
        });
    });
</script>
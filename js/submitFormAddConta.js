$(document).ready(function () {
    $('#formAddContas').submit(function () {
        var x = $("#saldoInput").val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById("saldoInput").value = x;
        var dados = jQuery(this).serialize();

        $.ajax({
            url: '../connections/insertConta.php',
            method: 'POST',
            data: dados,
            success: function (msg) {
                $("#formAddContas").trigger('reset');
            }
        });

        return false;
    });
});
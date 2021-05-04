$(document).ready(function () {
    $('#formAddContas').submit(function () {
        var x = $('#saldoInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('saldoInput').value = x;
        var dados = jQuery(this).serialize();

        $.ajax({
            url: '../connections/inserts/insertConta.php',
            method: 'POST',
            data: dados,
            success: function (msg) {
                $("#formAddContas").trigger('reset');
            }
        });

        return false;
    });

    $('#formAddDespesas').submit(function () {
        var x = $('#valorInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('valorInput').value = x;
        var dados = jQuery(this).serialize();

        $.ajax({
            url: '../connections/inserts/insertDespesa.php',
            method: 'POST',
            data: dados,
            success: function (msg) {
                $('#formAddDespesas').trigger('reset');
            }
        });

        return false;
    });
});
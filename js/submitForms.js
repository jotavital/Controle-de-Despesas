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
                window.location.href = "../pages/contas.php";
            }
        });

        return false;
    });

    $('#formAddDespesas').submit(function () {
        var x = $('#valorInput').val();
        x = x.replace(/[.]/gim, "");
        x = x.replace(/[,]/gim, ".");
        document.getElementById('valorInput').value = x;
        var dados = new FormData(this);

        $.ajax({
            url: '../connections/inserts/insertDespesa.php',
            method: 'POST',
            data: dados,
            processData: false,
            contentType: false,
            success: function (msg) {
                window.location.href = "../pages/despesas.php";
            }
        });

        return false;
    });
});
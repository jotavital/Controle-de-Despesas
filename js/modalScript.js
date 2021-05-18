
// desfoca o fundo quando o segundo modal está aberto!

$('.modal.fade').on('shown.bs.modal', function() {
    document.querySelector('#containerDashboard').classList.add('second-modal-open');
});

$('.modal.fade').on('hide.bs.modal', function() {
    document.querySelector('#containerDashboard').classList.remove('second-modal-open');
});
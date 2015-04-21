$(document).ready(function () {

    var boletosTable = $('#grid_boletos').DataTable({


        "dom": 'T<"clear">lfrtip',
        "retrieve": true,
        "oLanguage": {
            "sProcessing": "<img src='/images/ajax-loader.gif'>",
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext"    : "Próximo"
            }
        },
    });

    $('#grid_boletos tfoot th.searchable').each(function() {
        var title = $('#grid_boletos thead th').eq($(this).index()).text();
        $(this).html('<input style="width:100%" type="text" placeholder="Buscar ' + title + '" />');
    });

    boletosTable.columns().eq(0).each(function(colIdx) {
        $('input', boletosTable.column(colIdx).footer()).on('change', function() {
            boletosTable.column(colIdx).search(this.value).draw();
        })
    })

})
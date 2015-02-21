$(document).ready(function () {

    var boletosTable = $('#grid_boletos').DataTable({
        "processing": true,
        "serverSide": true,
        "dom": 'T<"clear">lfrtip',
        "retrieve": true,
        "tableTools": {
            "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
        },
        "oLanguage": {
            "sProcessing": "<img src='/images/ajax-loader.gif'>"
        },
        "ajax": {
            url: '/boleto/listar',
            type: 'GET',
        },
        "columns": [
            {"data": "emissao"},
            {"data": "vencimento"},
            {"data": "valor"},
            {"data": "chave"},
            {"data": "btn"}
        ],
        "columnDefs": [
            {
                "orderable": false,
                "targets": "no-orderable"
            }
        ],
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
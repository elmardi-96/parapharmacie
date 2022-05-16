$(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});
// alert('ziko');

$(document).ready(function(){
    $('#pdossier').DataTable({

            // 'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'/datatable'
            },
            'columns': [
                { data: 'id' },
                { data: 'code' },
                { data: 'nom' },
                { data: 'abreviation' },
                { data: 'description' },
                { data: 'actions' },
            ]

    });
    
    $('.test').click(function(){
            $("#pdossier").DataTable().ajax.reload();
    });

   
});
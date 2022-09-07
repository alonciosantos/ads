<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pagingType": "numbers",
            "order":[],
            "deferRender": true,
            "processing": true,
            "responsive":true,

            "language":{
                

                url:'https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json',
                                                           
            },
            ajax: '<?php echo route_to('get.archived.manager.adverts'); ?>',
            columns: [
                {
                    data: 'title'
                },
                {
                    data: 'code'
                },
                {
                    data: 'action'
                },

            ],
        });
    });
</script>
<script>
     
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order":[],
            "deferRender": true,
            "processing": true,
            "responsive":true,
            "language":{
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                
                url:'https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json',
                                             
            },
            ajax: '<?php echo route_to('categories.get.all'); ?>',
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'slug'
                },
                {
                    data: 'action'
                },

            ],
        });
    });
</script>
<script>
    $(document).ready(function() {
        
        $('#dataTable').DataTable({
            "order":[],
            "deferRender": true,
            "processing": true,
            "responsive":true,
            "language":{
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                
                url:'https://cdn.datatables.net/plug-ins/1.12.1/i18n/en-GB.json',
                                             
            },
            ajax: '<?php echo route_to('get.all.my.adverts'); ?>',
            columns: [{
                    data: 'image'
                },
                {
                    data: 'title'
                },
                {
                    data: 'code'
                },
                
                {
                    data: 'category'
                },
                {
                    data: 'is_published'
                },
                {
                    data: 'address'
                },
                {
                    data: 'action'
                },

            ],
        });
    });
</script>



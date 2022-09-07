<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order":[],
            "deferRender": true,
            "processing": true,
            "responsive":true,
            "language":{
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                                                           
            },
            ajax: '<?php echo route_to('get.all.my.adverts'); ?>',
            columns: [{
                    data: 'image'
                },
                {
                    data: 'code'
                },
                {
                    data: 'title'
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
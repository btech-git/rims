<div style="text-align: right">
    <?php echo ReportHelper::summaryText($serviceDataProvider); ?>
</div>

<div class="table-responsive" id="service-data-grid">
    <table class="table table-sm table-bordered table-hover" id="service-data-table">
        <thead>
            <tr class="table-primary">
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Type</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($serviceDataProvider->data as $service): ?>
                <tr data-service-id="<?php echo CHtml::value($service, 'id'); ?>">
                    <td><?php echo CHtml::encode(CHtml::value($service, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'serviceCategory.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'serviceType.name')); ?></td>
                    <td>
                        <span><?php echo CHtml::button('+', array('class' => 'btn btn-sm btn-success')); ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-end" id="service-data-pager">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $serviceDataProvider->pagination,
    )); ?>
</div>

<script>
    var addServiceAjaxUrl = "<?php echo CController::createUrl('ajaxHtmlAddServiceDetail', array('id' => '__id__', 'serviceId' => '__serviceId__')); ?>"
    $(document).ready(function() {
        $('#service-data-table > tbody > tr').on('click', function() {
            $(this).addClass('table-active');
            $('td > span > input[type=button]', this).addClass('d-none');
            $.ajax({
                type: "POST",
                dataType: "HTML",
                url: addServiceAjaxUrl.replace('__id__', '').replace('__serviceId__', $(this).attr('data-service-id')),
                data: $("form").serialize(),
                success: function(data) {
                    $("#detail-service").html(data);
                }
            });
        });
        $('#service-data-pager ul.yiiPager > li > a').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                dataType: "HTML",
                url: "<?php echo CController::createUrl('ajaxHtmlUpdateServiceDataTable'); ?>&service_page=" + $(this).attr('href').match(/[?&]service_page=([0-9]+)/)[1],
                data: $("form").serialize(),
                success: function(data) {
                    $("#service_data_container").html(data);
                }
            });
        });
    });
</script>

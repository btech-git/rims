<div style="text-align: right">
    <?php echo ReportHelper::summaryText($serviceDataProvider); ?>
</div>

<table id="service-data-table">
    <thead>
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Category</th>
            <th style="text-align: center">Type</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($serviceDataProvider->data as $service): ?>
            <tr data-service-id="<?php echo CHtml::value($service, 'id'); ?>">
                <td><?php echo CHtml::link(CHtml::value($service, 'id'), array('/master/service/view', 'id' => $service->id), array('target' => 'blank')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($service, 'code')); ?></td>
                <td><?php echo CHtml::link(CHtml::value($service, 'name'), array('/master/service/view', 'id' => $service->id), array('target' => 'blank')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($service, 'serviceCategory.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($service, 'serviceType.name')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    var addServiceAjaxUrl = "<?php echo CController::createUrl('ajaxHtmlAddServiceDetail', array('id' => '__id__', 'serviceId' => '__serviceId__')); ?>"
    $(document).ready(function() {
        $('#service-data-table > tbody > tr').on('click', function() {
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
    });
</script>

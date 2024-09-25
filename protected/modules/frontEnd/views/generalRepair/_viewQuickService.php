<table>
    <thead>
        <tr>
            <th>Quick Service</th>
            <th>Services</th>
            <th>Price</th>
            <th>Hour</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($quickServices as $key => $quickService): ?>
            <tr>
                <td><?php echo $quickService->quickService->code; ?></td>
                <td><?php
                    $first = true;
                    $rec = "";
                    $qsDetails = QuickServiceDetail::model()->findAllByAttributes(array('quick_service_id' => $quickService->quick_service_id));
                    foreach ($qsDetails as $qssDetail) {
                        $service = Service::model()->findByPk($qssDetail->service_id);
                        if ($first === true) {
                            $first = false;
                        } else {
                            $rec .= ', ';
                        }
                        $rec .= $service->name;
                    }
                    echo $rec;
                    ?></td>
                <td><?php echo number_format($quickService->price, 2); ?></td>
                <td><?php echo $quickService->hour; ?></td>
            </tr>
                <?php endforeach ?>
    </tbody>
</table>
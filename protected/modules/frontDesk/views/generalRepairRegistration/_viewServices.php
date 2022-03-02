<table>
    <thead>
        <tr>
            <th>Service name</th>
            <th>Price</th>
            <th>Discount Type</th>
            <th>Discount Price</th>
            <th>Total Price</th>
            <th>Hour</th>
            <th>Status</th>
            <th>Mechanic</th>
            <th>Duration</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if (count($services) > 0): ?>
            <?php foreach ($services as $i => $service): ?>
                <tr>
                    <td><?php echo $service->service->name; ?></td>
                    <td><?php echo number_format($service->price,2); ?></td>
                    <td><?php echo $service->discount_type; ?></td>
                    <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price,2);; ?></td>
                    <td><?php echo number_format($service->total_price,2); ?></td>
                    <td><?php echo $service->hour; ?></td>
                    <td><?php echo $service->status; ?></td>
                    <td><?php echo empty($service->start_mechanic_id) ? '' : $service->startMechanic->name; ?></td>
                    <td><?php echo $service->hour; ?></td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>
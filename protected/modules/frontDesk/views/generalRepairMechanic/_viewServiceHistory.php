<div style="height: 350px">
    <h1>Service History</h1>
    <table>
        <thead>
            <th>Service</th>
            <th>Date</th>
            <th>BR / GR</th>
            <th>Problem</th>
        </thead>
        
        <tbody>
            <?php foreach ($vehicle->registrationTransactions as $registrationTransaction): ?>
                <?php foreach ($registrationTransaction->registrationServices as $registrationService): ?>
                    <tr>
                        <td><?php echo $registrationService->service->name; ?></td>
                        <td><?php echo $registrationTransaction->transaction_date; ?></td>
                        <td><?php echo $registrationTransaction->repair_type; ?></td>
                        <td><?php echo $registrationTransaction->problem; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
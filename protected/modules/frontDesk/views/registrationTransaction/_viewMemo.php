<table>
    <thead>
        <tr>
            <th>Message</th>
            <th>Date</th>
            <th>Sent By</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($registrationMemos) > 0): ?>
            <?php foreach ($registrationMemos as $i => $registrationMemo): ?>
                <tr>
                    <td><?php echo $registrationMemo->memo; ?></td>
                    <td><?php echo $registrationMemo->date_time; ?></td>
                    <td><?php echo $registrationMemo->user->username; ?></td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>
<table>
    <tr>
        <td colspan="2">
            <?php $revisions = TransactionSentRequestApproval::model()->findAllByAttributes(array('sent_request_id' => $model->id));
            if (count($revisions) != 0) {
                ?>
                <table>
                    <thead>
                        <tr>
                            <td>Approval type</td>
                            <td>Revision</td>
                            <td>Date</td>
                            <td>Note</td>
                            <td>supervisor_id</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($revisions as $revision) : ?>
                            <tr>
                                <td><?php echo $revision->approval_type; ?></td>
                                <td><?php echo $revision->revision; ?></td>
                                <td><?php echo $revision->date; ?></td>
                                <td><?php echo $revision->note; ?></td>
                                <td><?php echo $revision->supervisor_id; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "NO REVISION HISTORY FOUND.";
            }
            ?>
        </td>
    </tr>
</table>

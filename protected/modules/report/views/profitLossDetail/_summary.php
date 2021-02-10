<style>
    .account {
        font-size: 8pt;
    }

    .summary td {
        border-top: 1px solid;
        font-weight: bold;
    }

    .number {
        text-align: right;
    }
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">LAPORAN LABA / RUGI</div>
</div> 

<br />
<br />

<table style="margin: 0 auto; width: 70%; font-size: larger">
    <?php $profitLossGross = 0.00; ?>
    <?php $profitLossNet = 0.00; ?>
    <?php foreach ($rows as $row): ?>
        <?php if ((int)$row['id'] === 29): ?>
            <tr class="summary">
                <td class="">LABA / RUGI KOTOR</td>
                <td class="number">
                    <?php echo Yii::app()->numberFormatter->format('#,##0.00', $profitLossGross); ?>
                </td>
            </tr>
        <?php endif; ?>
        <tr>
            <td><?php echo $row['name']; ?></td>       
            <td class="number">
                <?php echo Yii::app()->numberFormatter->format('#,##0.00', abs($row['amount'])); ?>
            </td>
        </tr>
        <?php if ((int)$row['id'] === 26 || (int)$row['id'] === 28): ?>
            <?php $profitLossGross += $row['amount']; ?>
        <?php endif; ?>
        <?php $profitLossNet += $row['amount']; ?>
    <?php endforeach; ?>
        <tr class="summary">
            <td class="">LABA / RUGI BERSIH</td>
            <td class="number">
                <?php echo Yii::app()->numberFormatter->format('#,##0.00', $profitLossNet); ?>
            </td>
        </tr>
</table>

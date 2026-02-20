<?php $logColumnWidth = '49%'; ?>
<?php $logHeaderLabelColumnWidth = '40%'; ?>
<?php $logDetailLabelColumnWidth = '35%'; ?>
<?php $logDetailLabelMarginLeft = '5%'; ?>

<?php $headerKeys = array_keys($payload1); ?>
<?php foreach ($headerKeys as $headerKey): ?>
    <?php if (!is_array($payload1[$headerKey]) && !is_array($payload2[$headerKey])): ?>
        <?php $color = $payload1[$headerKey] == $payload2[$headerKey] ? 'white' : 'pink'; ?>
        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: <?php echo $color; ?>">
            <div style="display: inline-block; width: <?php echo $logHeaderLabelColumnWidth; ?>; font-weight: bold"><?php echo $headerKey; ?></div>
            <div style="display: inline-block"><?php echo $payload1[$headerKey]; ?></div>
        </div>
        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: <?php echo $color; ?>">
            <div style="display: inline-block; width: <?php echo $logHeaderLabelColumnWidth; ?>; font-weight: bold"><?php echo $headerKey; ?></div>
            <div style="display: inline-block"><?php echo $payload2[$headerKey]; ?></div>
        </div>
    <?php else: ?>
        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; font-weight: bold"><?php echo $headerKey; ?></div>
        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; font-weight: bold"><?php echo $headerKey; ?></div>
        <?php for ($i = 0; $i < count($payload1[$headerKey]); $i++): ?>
            <?php $payload1Item = isset($payload1[$headerKey][$i]) ? $payload1[$headerKey][$i] : null; ?>
            <?php $payload2Item = isset($payload2[$headerKey][$i]) ? $payload2[$headerKey][$i] : null; ?>
            <?php $detailKeys = array_keys($payload1Item); ?>
            <div>&nbsp;</div>
            <?php foreach ($detailKeys as $detailKey): ?>
                <?php if (!is_array($payload1Item[$detailKey]) && !is_array($payload2Item[$detailKey])): ?>
                    <?php $color = $payload1Item[$detailKey] == $payload2Item[$detailKey] ? 'white' : 'pink'; ?>
                    <?php if ($payload1Item !== null): ?>
                        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: <?php echo $color; ?>">
                            <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold"><?php echo $detailKey; ?></div>
                            <div style="display: inline-block"><?php echo $payload1Item[$detailKey]; ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($payload2Item !== null): ?>
                        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: <?php echo $color; ?>">
                            <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold"><?php echo $detailKey; ?></div>
                            <div style="display: inline-block"><?php echo $payload2Item[$detailKey]; ?></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endfor; ?>
    <?php endif; ?>
<?php endforeach; ?>

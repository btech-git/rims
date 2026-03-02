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
        <?php $payload1Ids = array_map(function ($payload1Item) { return $payload1Item['id']; }, $payload1[$headerKey]); ?>
        <?php $payload2Ids = array_map(function ($payload2Item) { return $payload2Item['id']; }, $payload2[$headerKey]); ?>
        <?php $payloadIds = array_unique(array_merge($payload1Ids, $payload2Ids)); ?>
        <?php foreach ($payloadIds as $payloadId): ?>
            <?php $payload1Index = null; ?>
            <?php foreach ($payload1[$headerKey] as $i => $payload1Item): ?>
                <?php if ($payload1Item['id'] === $payloadId): ?>
                    <?php $payload1Index = $i; ?>
                    <?php break; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php $payload2Index = null; ?>
            <?php foreach ($payload2[$headerKey] as $i => $payload2Item): ?>
                <?php if ($payload2Item['id'] === $payloadId): ?>
                    <?php $payload2Index = $i; ?>
                    <?php break; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($payload1Index !== null && $payload2Index !== null): ?>
                <?php $payload1Item = $payload1[$headerKey][$payload1Index]; ?>
                <?php $payload2Item = $payload2[$headerKey][$payload2Index]; ?>
                <?php $detailKeys = array_keys($payload1Item); ?>
                <div>&nbsp;</div>
                <?php foreach ($detailKeys as $detailKey): ?>
                    <?php if (!is_array($payload1Item[$detailKey]) && !is_array($payload2Item[$detailKey])): ?>
                        <?php $color = $payload1Item[$detailKey] == $payload2Item[$detailKey] ? 'white' : 'pink'; ?>
                        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: <?php echo $color; ?>">
                            <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold"><?php echo $detailKey; ?></div>
                            <div style="display: inline-block"><?php echo $payload1Item[$detailKey]; ?></div>
                        </div>
                        <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: <?php echo $color; ?>">
                            <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold"><?php echo $detailKey; ?></div>
                            <div style="display: inline-block"><?php echo $payload2Item[$detailKey]; ?></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php elseif ($payload1Index !== null): ?>
                <?php $payload1Item = $payload1[$headerKey][$payload1Index]; ?>
                <?php $detailKeys = array_keys($payload1Item); ?>
                <div>&nbsp;</div>
                <?php foreach ($detailKeys as $detailKey): ?>
                    <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: pink">
                        <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold"><?php echo $detailKey; ?></div>
                        <div style="display: inline-block"><?php echo $payload1Item[$detailKey]; ?></div>
                    </div>
                    <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: pink">
                        <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold">&nbsp;</div>
                        <div style="display: inline-block">&nbsp;</div>
                    </div>
                <?php endforeach; ?>
            <?php elseif ($payload2Index !== null): ?>
                <?php $payload2Item = $payload2[$headerKey][$payload2Index]; ?>
                <?php $detailKeys = array_keys($payload2Item); ?>
                <div>&nbsp;</div>
                <?php foreach ($detailKeys as $detailKey): ?>
                    <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: pink">
                        <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold">&nbsp;</div>
                        <div style="display: inline-block">&nbsp;</div>
                    </div>
                    <div style="display: inline-block; width: <?php echo $logColumnWidth; ?>; background-color: pink">
                        <div style="display: inline-block; width: <?php echo $logDetailLabelColumnWidth; ?>; margin-left: <?php echo $logDetailLabelMarginLeft; ?>; font-weight: bold"><?php echo $detailKey; ?></div>
                        <div style="display: inline-block"><?php echo $payload2Item[$detailKey]; ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>

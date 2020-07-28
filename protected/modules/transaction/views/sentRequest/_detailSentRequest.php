<?php foreach ($sentRequest->details as $i => $detail): ?>
    <table>

        <tr>
            <td colspan="3">

                <?php
                $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Detail Item' => array(
                            'id' => 'test',
                            'content' => $this->renderPartial(
                                '_detail',
                                array(
                                    'i' => $i,
                                    'detail' => $detail,
                                    'product' => $product,
                                    'productDataProvider' => $productDataProvider,
                                    'sentRequest' => $sentRequest
                                ), true)
                        ),
                        'Detail Approval' => array(
                            'id' => 'test1',
                            'content' => $this->renderPartial(
                                '_detailApproval',
                                array('i' => $i, 'detail' => $detail, 'sentRequest' => $sentRequest), true)
                        ),
                        //'Detail Approval'=>'',

                        'Detail Delivery' => array(
                            'id' => 'test2',
                            'content' => $this->renderPartial(
                                '_detailDelivery',
                                array('i' => $i, 'detail' => $detail, 'sentRequest' => $sentRequest), true)
                        ),
                    ),


                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                    // set id for this widgets
                    'id' => 'Request' . $i . 'tab',
                ));
                ?>
            </td>
        </tr>
    </table>
<?php endforeach; ?>
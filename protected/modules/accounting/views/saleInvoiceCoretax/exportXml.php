<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <TIN>0013388111008000</TIN>
    <ListOfTaxInvoice>
        <?php foreach ($saleInvoiceHeaders as $saleInvoiceHeader): ?>
        <TaxInvoice>
            <TaxInvoiceDate><?php echo CHtml::value($saleInvoiceHeader, 'invoice_date'); ?></TaxInvoiceDate>
            <TaxInvoiceOpt>Normal</TaxInvoiceOpt>
            <TrxCode>04</TrxCode>
            <AddInfo/>
            <CustomDoc/>
            <RefDesc><?php echo $saleInvoiceHeader->invoice_number; ?></RefDesc>
            <FacilityStamp/>
            <SellerIDTKU>0013388111008000000000</SellerIDTKU>
            <BuyerTin><?php echo CHtml::value($saleInvoiceHeader, 'customer.tax_registration_number'); ?></BuyerTin>
            <BuyerDocument>TIN</BuyerDocument>
            <BuyerCountry>IDN</BuyerCountry>
            <BuyerDocumentNumber/>
            <BuyerName><?php echo CHtml::value($saleInvoiceHeader, 'customer.name'); ?></BuyerName>
            <BuyerAdress><?php echo CHtml::value($saleInvoiceHeader, 'customer.address'); ?></BuyerAdress>
            <BuyerEmail><?php echo CHtml::value($saleInvoiceHeader, 'customer.email'); ?></BuyerEmail>
            <BuyerIDTKU><?php echo CHtml::value($saleInvoiceHeader, 'customer.tax_registration_number'); ?>000000</BuyerIDTKU>
            <ListOfGoodService>
                <?php foreach ($saleInvoiceHeader->invoiceDetails as $saleInvoiceDetail): ?>
                <GoodService>
                    <?php if (empty($saleInvoiceDetail->service_id)): ?>
                        <Opt>A</Opt>
                        <Code>000000</Code>
                        <Name><?php echo CHtml::value($saleInvoiceDetail, 'product.name'); ?></Name>
                        <Unit>UM.0021</Unit>
                    <?php else: ?>
                        <Opt>B</Opt>
                        <Code>000000</Code>
                        <Name><?php echo CHtml::value($saleInvoiceDetail, 'service.name'); ?></Name>
                        <Unit>UM.0030</Unit>
                    <?php endif; ?>
                    <Price><?php echo CHtml::value($saleInvoiceDetail, 'unit_price'); ?></Price>
                    <Qty><?php echo CHtml::value($saleInvoiceDetail, 'quantity'); ?></Qty>
                    <TotalDiscount>0.00</TotalDiscount>
                    <TaxBase><?php echo CHtml::value($saleInvoiceDetail, 'total_price'); ?></TaxBase>
                    <OtherTaxBase><?php echo CHtml::value($saleInvoiceDetail, 'totalWithCoretax'); ?></OtherTaxBase>
                    <VATRate>12</VATRate>
                    <VAT><?php echo CHtml::value($saleInvoiceDetail, 'totalWithTax'); ?></VAT>
                    <STLGRate>0</STLGRate>
                    <STLG>0.00</STLG>
                </GoodService>
                <?php endforeach; ?>
            </ListOfGoodService>
        </TaxInvoice>
        <?php endforeach; ?>
    </ListOfTaxInvoice>
</TaxInvoiceBulk>

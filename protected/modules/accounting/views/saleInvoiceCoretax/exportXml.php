<?xml version="1.0" encoding="utf-8"?>
<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <TIN>0031486434413000</TIN>
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
            <SellerIDTKU>0031486434413000000000</SellerIDTKU>
            <BuyerTin><?php echo CHtml::value($saleInvoiceHeader, 'customer.tax_registration_number'); ?></BuyerTin>
            <BuyerDocument>TIN</BuyerDocument>
            <BuyerCountry>IDN</BuyerCountry>
            <BuyerDocumentNumber/>
            <BuyerName><?php echo CHtml::value($saleInvoiceHeader, 'customer.name'); ?></BuyerName>
            <BuyerAdress><?php echo htmlspecialchars(CHtml::value($saleInvoiceHeader, 'customer.address'), ENT_XML1); ?></BuyerAdress>
            <BuyerEmail><?php echo CHtml::value($saleInvoiceHeader, 'customer.email'); ?></BuyerEmail>
            <BuyerIDTKU><?php echo CHtml::value($saleInvoiceHeader, 'customer.tax_registration_number'); ?>000000</BuyerIDTKU>
            <ListOfGoodService>
<?php foreach ($saleInvoiceHeader->invoiceDetails as $saleInvoiceDetail): ?>
                <GoodService>
                    <Opt>A</Opt>
                    <Code>720000</Code>
                    <Name><?php if (empty($saleInvoiceDetail->service_id)): ?><?php echo CHtml::value($saleInvoiceDetail, 'product.name'); ?><?php else: ?><?php echo CHtml::value($saleInvoiceDetail, 'service.name'); ?><?php endif; ?></Name>
                    <Unit><?php if (empty($saleInvoiceDetail->service_id)): ?>UM.0018<?php else: ?>UM.0021<?php endif; ?></Unit>
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

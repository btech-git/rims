<?php

class JurnalUmumSummary extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
		//$this->dataProvider->criteria->together = array('true');

		// $this->dataProvider->criteria->with = array(
		// 	'transaksiInvoiceDetails' => array(
		// 		'joinType' => 'INNER JOIN',
		// 		'on' => 'invoice_id = t.id',
		// 	), 
		// 	'pelanggan',
		// );
		// $this->dataProvider->criteria->together = true;
	}
	
	public function setupPaging($pageSize, $currentPage)
	{
		$pageSize = (empty($pageSize)) ? 30 : $pageSize;
		$pageSize = ($pageSize <= 0) ? 1 : $pageSize;
		$this->dataProvider->pagination->pageSize = $pageSize;
		
		$currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
		$this->dataProvider->pagination->currentPage = $currentPage;
	}
	
	public function setupSorting()
	{
		$this->dataProvider->sort->attributes = array('t.tanggal_transaksi');
		$this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;

	}
	
	public function setupFilter($tanggal_mulai, $tanggal_sampai)
	{
		//$tanggal_mulai = (empty($tanggal_mulai)) ? date('Y-m-d') : $tanggal_mulai;
		//$tanggal_sampai = (empty($tanggal_sampai)) ? date('Y-m-d') : $tanggal_sampai;
		//$pelanggan_mulai = (empty($pelanggan_mulai)) ? 0 : $pelanggan_mulai;
		//$pelanggan_selesai = (empty($pelanggan_selesai)) ? 0 : $pelanggan_selesai;
		//$this->dataProvider->criteria->addBetweenCondition('t.pelanggan_id', $pelanggan_mulai, $pelanggan_selesai);
		$this->dataProvider->criteria->addBetweenCondition('t.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
		//$jenis_persediaan_id = (empty($jenis_persediaan_id)) ? 0 : $jenis_persediaan_id;
		//$this->dataProvider->criteria->addCondition('t.status_sales_order = "aktif"');
		//$this->dataProvider->criteria->addCondition('transaksiOrderPenjualanDetails.kuantitas_sisa > 0 ');
		$this->dataProvider->pagination = false;
	}
	
	public function getGrandTotal()
	{
		$total = 0.00;
		
		foreach ($this->dataProvider->data as $header)
			$total += $header->grandTotal;
		
		return $total;
	}
}

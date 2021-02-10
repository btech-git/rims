<?php

class RegistrationServices extends CComponent
{
	public $header;
	//public $divisonDetails;
	public $employeeDetails;
	public $supervisorDetails;
	

	public function __construct($header, array $employeeDetails, array $supervisorDetails) 
	{
		$this->header = $header;
		//$this->divisonDetails = $divisonDetails;
		$this->employeeDetails = $employeeDetails;
		$this->supervisorDetails = $supervisorDetails;
	}

	public function addEmployeeDetail($employeeId)
	{
		$e = Employee::model()->findByPk($employeeId);
		if($e->availability == "Yes"){
			$employee = new RegistrationServiceEmployee();
			$employee->employee_id = $employeeId;
			//$levelData = Level::model()->findByPk($level->level_id);
			//$level->position_name = $positionData->name;
			$this->employeeDetails[] = $employee;
		}
	}

	public function addSupervisorDetail($supervisorId)
	{
		$supervisor = new RegistrationServiceSupervisor();
		$supervisor->supervisor_id = $supervisorId;
		//$levelData = Level::model()->findByPk($level->level_id);
		//$level->position_name = $positionData->name;
		$this->supervisorDetails[] = $supervisor;
	}
	
	
	public function removeEmployeeDetailAt($index)
	{
		array_splice($this->employeeDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}

	public function removeSupervisorDetailAt($index)
	{
		array_splice($this->supervisorDetails, $index, 1);
		//var_dump(CJSON::encode($this->details));
	}
	
	
	public function save($dbConnection)
	{
		$dbTransaction = $dbConnection->beginTransaction();
		try
		{
			$valid = $this->validate() && $this->flush();
			if ($valid){
				$dbTransaction->commit();
				//print_r('1');
			} else {
				$dbTransaction->rollback();
				//print_r('2');
			}

		}
		catch (Exception $e)
		{
			$dbTransaction->rollback();
			$valid = false;
			//print_r($e);
		}

		return $valid;
		//print_r('success');
	}

	public function validate()
	{
		$valid = $this->header->validate();

		//$valid = $this->validateDetailsCount() && $valid;

		if (count($this->employeeDetails) > 0)
		{
			foreach ($this->employeeDetails as $employeeDetail)
			{
				$fields = array('employee_id');
				$valid = $employeeDetail->validate($fields) && $valid;
				echo $valid;
			}
		}
		else {
			$valid = true;
		}

		//print_r($valid);
		return $valid;
	}

	public function validateDetailsCount()
	{
		$valid = true;
		if (count($this->employeeDetails) === 0)
		{
			$valid = false;
			$this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
		}

		return $valid;
	}


	public function flush()
	{
		$isNewRecord = $this->header->isNewRecord;
		$valid = $this->header->save();
		//echo $valid;
		$real = RegistrationRealizationProcess::model()->findByAttributes(array('registration_transaction_id'=>$this->header->registration_transaction_id,'service_id'=>$this->header->service_id));
		$real->detail = $this->header->status;
		$real->detail .='<br>';
		$real->detail .= 'Notes from Idle : '.$this->header->note;
		$real->save(false);

		$registrationServiceEmployees = RegistrationServiceEmployee::model()->findAllByAttributes(array('registration_service_id'=>$this->header->id));

		$registrationServiceEmployeeId = array();
		$employeeId = array();

		foreach($registrationServiceEmployees as $registrationServiceEmployee)
		{
			$registrationServiceEmployeeId[]=$registrationServiceEmployee->id;
			$employeeId[]=$registrationServiceEmployee->employee_id;
		}

		$new_detail = array();
		$new_employee_id = array();

		//Checklist Module
		foreach ($this->employeeDetails as $employeeDetail)
		{
			//Employee::model()->updateByPk($employeeDetail->employee_id, 'availability = :availability', array('availability'=>'No'));

			$employee=Employee::model()->findByPk($employeeDetail->employee_id);
			$employee->availability = 'No';
			$employee->registration_service_id = $this->header->id;
			$employee->save(); // save the change to database

			$employeeDetail->registration_service_id = $this->header->id;


			
			$valid = $employeeDetail->save(false) && $valid;
			$new_detail[] = $employeeDetail->id;
			$new_employee_id[] = $employeeDetail->employee_id;

		}

		//delete employee
		$delete_array = array_diff($registrationServiceEmployeeId, $new_detail);
		$update_employee_array = array_diff($employeeId, $new_employee_id);
		if($delete_array != NULL)
		{
			
			foreach ($update_employee_array as $key => $update_employee) {
				$employee=Employee::model()->findByPk($update_employee);
				$employee->availability = 'Yes';
				$employee->registration_service_id = NULL;
				$employee->save(); // save the change to database

			}
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_array);
			RegistrationServiceEmployee::model()->deleteAll($criteria);
		}

		//Add Supervisors
		$registrationServiceSupervisors = RegistrationServiceSupervisor::model()->findAllByAttributes(array('registration_service_id'=>$this->header->id));

		$registrationServiceSupervisorId = array();
		$supervisorId = array();

		foreach($registrationServiceSupervisors as $registrationServiceSupervisor)
		{
			$registrationServiceSupervisorId[]=$registrationServiceSupervisor->id;
			$supervisorId[]=$registrationServiceSupervisor->supervisor_id;
		}

		$new_supervisor_detail = array();
		$new_supervisor_id = array();


		foreach ($this->supervisorDetails as $supervisorDetail)
		{
			$supervisorDetail->registration_service_id = $this->header->id;

			$valid = $supervisorDetail->save(false) && $valid;
			$new_supervisor_detail[] = $supervisorDetail->id;
			$new_supervisor_id[] = $supervisorDetail->supervisor_id;

		}

		//delete supervisor
		$delete_supervisor_array = array_diff($registrationServiceSupervisorId, $new_supervisor_detail);
		$update_supervisor_array = array_diff($supervisorId, $new_supervisor_id);
		if($delete_supervisor_array != NULL)
		{
			
			/*foreach ($update_supervisor_array as $key => $update_supervisor) {
				$employee=Employee::model()->findByPk($update_employee);
				$employee->availability = 'Yes';
				$employee->save(); // save the change to database

			}*/
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$delete_supervisor_array);
			RegistrationServiceSupervisor::model()->deleteAll($criteria);
		}

		return $valid;

	}
}

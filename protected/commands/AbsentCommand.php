<?php 
	class AbsentCommand extends CConsoleCommand
	{
	  public function actionSave()
	  {
	  	$users = Users::model()->findAll();
	  	foreach ($users as $key => $user) {
	  		if ($user->employee_id != "NULL") {
	  			$model = new EmployeeAttendance();
		    	$model->employee_id = $user->employee_id;
		    	$model->user_id = $user->id;
		    	$model->date = date('Y-m-d');
		    	$model->login_time = '00:00:00';
		    	$model->logout_time = '00:00:00';
		    	$model->total_hour = 0;
		    	$model->notes = "No Overtime";
		    	if ($model->save()) {
		    		echo "success";
		    	}
	  			//echo $user->id;
	  			// echo $user->employee_id;
	  		}
	  		
	  	}
	  	// $model = new EmployeeAttendance();
    // 	$model->employee_id = 29;
    // 	$model->user_id = 1;
    // 	$model->date = date('Y-m-d');
    // 	$model->login_time = '00:00:00';
    // 	$model->logout_time = '00:00:00';
    // 	$model->total_hour = 0;
    // 	$model->notes = "No Overtime";
    // 	if ($model->save()) {
    // 		echo "success";
    // 	}

	   
	  }
		// public function actionQuery(){
	 //  		$model = User::model()->findByPk(1);
	 //  		echo $model->id;
	 //  	}
	}
 ?>
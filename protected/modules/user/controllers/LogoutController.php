<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
//		$this->attendance();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

//	private function attendance(){
//		$userData = User::model()->notsafe()->findByPk(Yii::app()->user->id);
//
//		// $check = EmployeeAttendance::model()->findbyAttributes(array('user_id'=>$userData->id));
//		// if(count($check) == 0){
//			$attendance = EmployeeAttendance::model()->findbyAttributes(array('user_id'=>$userData->id,'date'=>date('y-m-d')));;
//			// $attendance->employee_id = $userData->employee_id;
//			//$attendance->date = date('y-m-d');
//			//$attendance->login_time = date('H:i:s');
//			if (count($attendance) !=0) {
//				$from = new DateTime($attendance->login_time);
//				$to = new DateTime(date('H:i:s'));
//
//				
//				$attendance->logout_time = date('H:i:s');
//				$attendance->total_hour = $from->diff($to)->format('%h.%i'); // 5.10
//				$attendance->notes = $attendance->total_hour > 8 ? 'Overtime' : 'No Overtime';
//				// $attendance->user_id = $userData->id;
//				$attendance->save();
//			}
//			
//		// }
//		
//		
//	}

}
<?php
App::uses('Helper', 'View');
class GlobalHelper extends Helper {

	public $components = array('Session');
	
	public function program_name($id){
		$this->Program = ClassRegistry::init('Program');
		$program = $this->Program->find('first', array(
			'conditions'=>array(
				'Program.id'=>$id
			),
			'fields'=>array('name')
		));
		return $program['Program']['name'];
	}
	
	public function student_program($student_id, $school_id){
		$this->StudentProgram = ClassRegistry::init('StudentProgram');
		$student_program = $this->StudentProgram->find('first', array(
			'conditions'=>array(
				'StudentProgram.student_id'=>$student_id,
				'StudentProgram.school_id'=>$student_id,
			),
			'contain'=>array(
				'Program'=>array('id','name')
			)
		));
		
		return count($student_program) == 0 ? false : $student_program;
	}

}
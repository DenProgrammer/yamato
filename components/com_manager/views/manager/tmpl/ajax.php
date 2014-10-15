<?php if(!defined( '_JEXEC' ) ) die( 'Direct Access is not allowed.' );

	$data->cars = array();
	foreach($this->cars as $car) {
		$obj = new stdClass;
		$obj->image = $car->product_thumb_image;
		$obj->id = $car->product_id;
		$obj->name = $car->marka.' '.$car->model;
		$obj->nomer = $car->NomerKuzov;
		$obj->year = $car->year;
		$obj->cagent = $car->cagent;
		$obj->price = 'Цена : '.round($car->price,2).' '.$car->currency;
		$obj->probeg = $car->Probeg;
		
		$data->cars[] = $obj;
	}
	
	$data->is_lost = $this->is_lost;
	$data->count = 10000;
	
	echo json_encode($data);
?>
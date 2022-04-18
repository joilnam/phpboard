<?php
include '../config.php';

if ($_GET['action'] == "table_data") {
	$query = $mysqli->query("SELECT * FROM tbl  ");
	$totalNumrow = $query->num_rows;
	$data = array();
	$no = 1;
	while ($r = $query->fetch_array()) {
		$id = $r['id'];
		$row = array();
		$row[] = $no;
		$row[] = $r['name'];
		$row[] = $r['adress'];
		$row[] = $r['major'];
		$row[] = '<div class="text-center">
	   			   <a style="color:#fff;" class="btn btn-primary" onclick="form_edit(' . $id . ')">수정</a>
	   			   <a style="color:#fff;" class="btn btn-danger" onclick="delete_data(' . $id . ')">삭제</a>
	   			 </div>';
		$data[] = $row;
		$no++;
	}

	$output = array("draw" => 1, "recordsTotal" => $totalNumrow, "recordsFiltered" => $totalNumrow, "data" => $data);
	echo json_encode($output);
} elseif ($_GET['action'] == "form_data") {
	$query = $mysqli->query("SELECT * FROM tbl WHERE id='$_GET[id]'");
	$data  = $query->fetch_array();
	echo json_encode($data);
} elseif ($_GET['action'] == "insert") {
	$result = $mysqli->query("INSERT INTO tbl SET
      name    = '$_POST[name]',
      adress  = '$_POST[adress]',
      major = '$_POST[major]'");
} elseif ($_GET['action'] == "update") {

	$result = $mysqli->query("UPDATE tbl SET
      name    = '$_POST[name]',
      adress  = '$_POST[adress]',
      major = '$_POST[major]'
      WHERE id ='$_POST[id]'");
} elseif ($_GET['action'] == "delete") {
	$result = $mysqli->query("DELETE FROM tbl WHERE id='$_GET[id]'");
}

<?php 
class EditModel extends MainModel
{
	function FetchObj($id=null, $startdb=null){
		$fitch = $this->db->prepare("SELECT * FROM tasks WHERE id='{$id}'");
		$fitch->execute();
		return  $fitch->fetch(PDO::FETCH_ASSOC);
	}
	function EditTask($data)
	{
		$edit = ($data['task']['dat']!=$data['old']['dat']) ? '1' : '0';
		$sql = "UPDATE tasks SET name='{$data['name']['dat']}', email='{$data['email']['dat']}', task='{$data['task']['dat']}', edit='{$edit}' WHERE id='{$data['id']['dat']}'";
		$fitch = $this->db->prepare($sql);
		$fitch->execute();
	}
}
?>
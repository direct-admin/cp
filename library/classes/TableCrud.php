<?php

class TableCrud {
	
	private $data_array;
	private $header_array;
	private $result;
	private $table_columns;
	private $ActionLinks;
	private $paging;
	
	
	public function __construct($array){
		$this->data_array = $array;
	}
	
	public function AddHeaders($headers = array()){
		$this->header_array = $headers;
	}
	
	public function Table_Columns($columns = array()){
		$this->table_columns = $columns;
	}
	
	
	public function AddActionLinks($links){
		$this->ActionLinks = $links;
		$this->AddLinks2Array($this->data_array);
	}
	
	
	public function AddActionModalLinks($links){
		$this->ActionLinks = $links;
		$this->AddLinks2ModalArray($this->data_array);
	}
	
	
	public function searcharray($value, $key, $array) {
   		foreach ($array as $k => $val) {
       		if ($val[$key] == $value) {
           		return $k;
       		}
  		 }
   			return null;
	}

	
	public function SearchAndReplace($dataset = array(), $fieldtocheck, $replacefields)
	{
		
		for($i=0;$i<count($this->data_array);$i++)
		{
			
			for($j=0;$j<count($dataset);$j++)
			{
				$dt="";
				
				$checkvalue = array_search($dataset[$j][$fieldtocheck],$this->data_array[$i]);
				
				if(!empty($checkvalue))
				{
					
					for($t=0;$t<count($replacefields);$t++)
					{
						$dt .= $dataset[$j][$replacefields[$t]]." ";
					}
					
					$this->data_array[$i][$checkvalue] = $dt;
					
				}
			}
		
		}
		
				
	}
	
	

	
	public function FormatDate($dateformat, $fieldname,$strcheck){
		
		for($k=0;$k<count($this->data_array);$k++){
			
			if(!empty($this->data_array[$k][$fieldname]))
		{
			if($strcheck == "true")
			{
			$this->data_array[$k][$fieldname] = date($dateformat,strtotime($this->data_array[$k][$fieldname]));
			}
			else
			{
			$this->data_array[$k][$fieldname] = date($dateformat,$this->data_array[$k][$fieldname]);	
			}
		}
		
		else
		{
		$this->data_array[$k][$fieldname] = "-";	
		}
		
		
		}
		
		
	}
	
	
	public function LimitText($fieldname,$length){
		
		for($k=0;$k<count($this->data_array);$k++){
		
		if(strlen($this->data_array[$k][$fieldname]) > $length)
		{
			$this->data_array[$k][$fieldname] = substr($this->data_array[$k][$fieldname],0,$length)."...";
		}
		
			
		}
		
		
	}
	
	
	public function CreateLink($linkdata,$fieldname){

		for($k=0;$k<count($this->data_array);$k++){
			
			for($t=0;$t<count($linkdata);$t++){
				
			if($this->data_array[$k][$fieldname] == $linkdata[$t]['checkvalue']) {
				
				!empty($linkdata[$t]['function']) ? $lkfun = $linkdata[$t]['function'] ."=". $linkdata[$t]['function_trigger']."('".$linkdata[$t]['function_file']."','".$linkdata[$t]['function_params']."=".$this->data_array[$k][$linkdata[$t]['function_params']].$linkdata[$t]['moreparams']."','".$linkdata[$t]['divid'].$this->data_array[$k][$linkdata[$t]['ajaxid']]."')" : $lkfun ="";
				
				!empty($linkdata[$t]['linkparam']) ? $lkparam = "?" . $linkdata[$t]['linkalias'] . "=" . $this->data_array[$k][$linkdata[$t]['linkparam']]   : $lkparam ="";
				
				$this->data_array[$k][$fieldname] = "<div id='".$linkdata[$t]['divid'].$this->data_array[$k][$linkdata[$t]['ajaxid']]."'><a href='".$linkdata[$t]['linkpage'].$lkparam."' ".$lkfun." target='".$linkdata[$t]['target']."' class='".$linkdata[$t]['linkcss']."'>".$linkdata[$t]['linkicon']."</a></div>";
				
			}
			
			}
		}
		
	}
	
	
		
	public function AddLinks2Array($alink = array()){
		
		if(!empty($alink))
			{
				
				for($k=0;$k<count($this->data_array);$k++){
					
					$actionlinks ="";
					
					for($t=0;$t<count($this->ActionLinks);$t++)
					{
					
					if(!empty($this->ActionLinks[$t]['linkparam']))
					{
					
				 $actionlinks .="<a href='".$this->ActionLinks[$t]['linkfile']."?".$this->ActionLinks[$t]['linkalias']."=".$this->data_array[$k][$this->ActionLinks[$t]['linkparam']].$this->ActionLinks[$t]['moreparams']."' class='".$this->ActionLinks[$t]['linkcss']."' title='".$this->ActionLinks[$t]['linkdesc']."' target='".$this->ActionLinks[$t]['target']."'>".$this->ActionLinks[$t]['linkicon']."</a>&nbsp;";
				 
					}
					else
					{
					$actionlinks .="<a href='".$this->ActionLinks[$t]['linkfile']."' class='".$this->ActionLinks[$t]['linkcss']."' title='".$this->ActionLinks[$t]['linkdesc']."' target='".$this->ActionLinks[$t]['target']."'>".$this->ActionLinks[$t]['linkicon']."</a>&nbsp;";	
					}
				
					}
					
					$this->data_array[$k]['action'] = $actionlinks;
					
				}
				
			}
		
	}
	
	
	public function CombineColumns($combine_columns=array(),$combinewith, $bind_column)
	{
		
		if(!empty($combine_columns))
			{
				
				for($k=0;$k<count($this->data_array);$k++){
					
					$this->data_array[$k][$bind_column] = $this->data_array[$k][$combine_columns[0]] . $combinewith . $this->data_array[$k][$combine_columns[1]];
					
					
				}
				
			}
	
	
	}
	
	public function AddLinks2ModalArray($alink = array()){
		
		if(!empty($alink))
			{
				
				for($k=0;$k<count($this->data_array);$k++){
					
					$actionlinks ="";
					
					for($t=0;$t<count($this->ActionLinks);$t++)
					{
					
					if(!empty($this->ActionLinks[$t]['linkparam']))
					{
					
				 $actionlinks .="<a href='".$this->ActionLinks[$t]['linkfile'].$this->data_array[$k][$this->ActionLinks[$t]['linkparam']].$this->ActionLinks[$t]['moreparams']."' class='".$this->ActionLinks[$t]['linkcss']."' title='".$this->ActionLinks[$t]['linkdesc']."' data-toggle='modal' target='".$this->ActionLinks[$t]['target']."'>".$this->ActionLinks[$t]['linkicon']."</a>&nbsp;";
				 
					}
					else
					{
					$actionlinks .="<a href='".$this->ActionLinks[$t]['linkfile']."' class='".$this->ActionLinks[$t]['linkcss']."' title='".$this->ActionLinks[$t]['linkdesc']."' target='".$this->ActionLinks[$t]['target']."'>".$this->ActionLinks[$t]['linkicon']."</a>&nbsp;";	
					}
				
					}
					
					$this->data_array[$k]['modal'] = $actionlinks;
					
				}
				
			}
		
	}
	
	
	public function GenrateTable() {
		
		$result = '<div class="table-responsive"><table class="table table-bordered table-hover table-striped tablesorter" id="dataTables"><thead><tr>';
	
		foreach ($this->header_array as $headername)
		{
		$result .= "<th>".$headername."</th>";	
		}
		$result .= '</tr>
		</thead>
		<tbody>';
		
		
		for($i=0;$i<count($this->data_array);$i++)
		{
			$result .= "<tr class='gradeX'>";
			
			foreach($this->table_columns as $column)
			{
			$result .= "<td>".$this->data_array[$i][$column]."</td>";
			}
			
			$result .= "</tr>";
		}
		
		$result .= "</tbody></table></div>";
		
		return $result;
		
	}
	
	
	
	public function Pagination($noofpages,$url) {
		
		$this->paging = "<div class='text-right'><ul class='pagination pagination-sm m-t-none m-b-none'>";
		
		for($p=1;$p<=$noofpages;$p++)
		{
		
		$this->paging .= "<li><a href='".$url."?page=".$p."'>".$p."</a></li>";	
			
		}
		
		$this->paging .= "</ul></div>";
		
		return $this->paging;
		
	}
	
	
	
}

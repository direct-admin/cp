<?php
class FormClass
{
	
	public $formtype;
	
	private $formfields = array();
	
	private $formbuttons = array();
	
	private $result;
	
	public function __construct($formtype="POST"){
		$this->formtype = $formtype;
	}
	
	public function AddFields($fieldnames = array()){
		$this->formfields = $fieldnames;
	}
	
	public function AddButtons($fieldbuttons = array()){
		$this->formbuttons = $fieldbuttons;
	}
	
	public function GenrateForm(){
				  
				  // add form element in the form genrator first
				  $this->result .= "<form role='form' method='".$this->formtype."' data-validate='parsley'  enctype='multipart/form-data'>";
				  
				  // add form fields
				  for($i=0;$i<count($this->formfields);$i++)
				  {
				  
				  // check if form field is text
				  if($this->formfields[$i]['fieldtype'] == "text" || $this->formfields[$i]['fieldtype'] == "email" || $this->formfields[$i]['fieldtype'] == "password" || $this->formfields[$i]['fieldtype'] == "file")
				  {
				  $datatype = !empty($this->formfields[$i]['data-type']) ? "data-type='".$this->formfields[$i]['data-type']."'" : "";
				  
				  $datavalidator = !empty($this->formfields[$i]['validator']) ? $this->formfields[$i]['validator'] : "";
				  
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";
				  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>
				  <input type='".$this->formfields[$i]['fieldtype']."' class='form-control' id='".$this->formfields[$i]['fieldname']."' name='".$this->formfields[$i]['fieldname']."' placeholder='".$this->formfields[$i]['fieldplaceholder']."' value='".$this->formfields[$i]['fieldvalue']."' ".$datatype."  ".$datavalidator." ".$datarequired.">
				</div>";
				  }
				  
				  
				  // check if form field is text with group insert
				  if($this->formfields[$i]['fieldtype'] == "textgroup")
				  {
				  $datatype = !empty($this->formfields[$i]['data-type']) ? "data-type='".$this->formfields[$i]['data-type']."'" : "";
				  
				  $datavalidator = !empty($this->formfields[$i]['validator']) ? $this->formfields[$i]['validator'] : "";
				  
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";
				  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>
				  
				  <div class='input-group'>             
	
				  <input type='".$this->formfields[$i]['fieldtype']."' class='form-control' id='".$this->formfields[$i]['fieldname']."' name='".$this->formfields[$i]['fieldname']."' placeholder='".$this->formfields[$i]['fieldplaceholder']."' value='".$this->formfields[$i]['fieldvalue']."' ".$datatype."  ".$datavalidator." ".$datarequired.">
				  
				  <div class='input-group-addon'>".$this->formfields[$i]['textgroup']."</div>
    </div>
				  
				  
				</div>";
				  }
				  
				  
				  // check if form field is text with select group insert
				  else if($this->formfields[$i]['fieldtype'] == "selectgroup")
				  {
				  $datatype = !empty($this->formfields[$i]['data-type']) ? "data-type='".$this->formfields[$i]['data-type']."'" : "";
				  
				  $datavalidator = !empty($this->formfields[$i]['validator']) ? $this->formfields[$i]['validator'] : "";
				  
				  $prepend = !empty($this->formfields[$i]['prepend']) ? $this->formfields[$i]['prepend'] : "";
				  
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";
				  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>
				  
				  <div class='input-group'>             
	
				  <input type='".$this->formfields[$i]['fieldtype']."' class='form-control' id='".$this->formfields[$i]['fieldname']."' name='".$this->formfields[$i]['fieldname']."' placeholder='".$this->formfields[$i]['fieldplaceholder']."' value='".$this->formfields[$i]['fieldvalue']."' ".$datatype."  ".$datavalidator." ".$datarequired.">
				  
				  <div class='input-group-addon'><select name='".$this->formfields[$i]['selectgroupfieldname']."' id='".$this->formfields[$i]['selectgroupfieldname']."'>";
				  
				  for($s=0;$s<count($this->formfields[$i]['selectgroup']);$s++)
				  {
					  
					$this->result .= "<option value='".$this->formfields[$i]['selectgroup'][$s][$this->formfields[$i]['selectgroupvaluefield']]."'>".$prepend.$this->formfields[$i]['selectgroup'][$s][$this->formfields[$i]['selectgrouptextfield']]." </option>";  
					  
				  }
				  
				  
				  $this->result .="</select></div>
    </div>
				  
				  
				</div>";
				  }
				  
				  
				  // check if form field is Wysiwyg
				  else if($this->formfields[$i]['fieldtype'] == "tinymce")
				  {
				  $datatype = !empty($this->formfields[$i]['data-type']) ? "data-type='".$this->formfields[$i]['data-type']."'" : "";
				  
				  $datavalidator = !empty($this->formfields[$i]['validator']) ? $this->formfields[$i]['validator'] : "";
				  
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";
				  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>
				  
				  <textarea class='form-control editme' id='".$this->formfields[$i]['fieldname']."' name='".$this->formfields[$i]['fieldname']."' placeholder='".$this->formfields[$i]['fieldplaceholder']."' ".$datatype."  ".$datavalidator." ".$datarequired.">".$this->formfields[$i]['fieldvalue']."</textarea>
				  
				
				</div>";
				  }
				  
				  
				  
				   // check if form field is text with ajax check
				  else if($this->formfields[$i]['fieldtype'] == "ajaxtext")
				  {
				  $datatype = !empty($this->formfields[$i]['data-type']) ? "data-type='".$this->formfields[$i]['data-type']."'" : "";
				  
				  $datavalidator = !empty($this->formfields[$i]['validator']) ? $this->formfields[$i]['validator'] : "";
				  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>
				  <input type='".$this->formfields[$i]['fieldtype']."' class='form-control' id='".$this->formfields[$i]['fieldname']."' name='".$this->formfields[$i]['fieldname']."' placeholder='".$this->formfields[$i]['fieldplaceholder']."' value='".$this->formfields[$i]['fieldvalue']."' ".$datatype."  ".$datavalidator." data-required='".$this->formfields[$i]['data-required']."' onKeyUp=\"htmlData('".$this->formfields[$i]['ajaxfilename']."','data='+this.value,'".$this->formfields[$i]['resultdiv']."')\"><div id='".$this->formfields[$i]['resultdiv']."'></div>
				</div>";
				  }
				  
				  
				  
				  // check if form field is ajaxdropdown
				  else if($this->formfields[$i]['fieldtype'] == "ajaxselect")
				  {
					  
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";
				  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label><select class='form-control chosen-select' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' onChange=\"htmlData('".$this->formfields[$i]['ajaxfilename']."','data='+this.value,'".$this->formfields[$i]['resultdiv']."')\"  ".$datarequired.">";
				  
				  $this->result .= "<option value=''>Select</option>";
				  
				  for($s=0;$s<count($this->formfields[$i]['fielddefaultvalue']);$s++)
				  {
					  
					  if(!empty($this->formfields[$i]['selectedvalue']) and $this->formfields[$i]['selectedvalue'] == $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']])
					  {
						$fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
						 
						 $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."' selected>".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>";
						  
					  }
					  else
					  {
				  $fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
				  $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."'>".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>";
				  
					  }
				  
				  }
				  
				  $this->result .="</select></div>";
				  }
				  
				  		  
				  // check if form field is dropdown
				  else if($this->formfields[$i]['fieldtype'] == "select")
				  {
					
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";  

				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label><select class='form-control chosen-select' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' ".$datarequired.">";
				  
				  $this->result .= "<option value=''>Select</option>";
				  
				  for($s=0;$s<count($this->formfields[$i]['fielddefaultvalue']);$s++)
				  {
					  
					  if(!empty($this->formfields[$i]['selectedvalue']) and $this->formfields[$i]['selectedvalue'] == $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']])
					  {
						$fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
						 
						 $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."' selected>".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>";
						  
					  }
					  else
					  {
				  $fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
				  $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."'>".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>";
				  
					  }
				  
				  }
				  
				  $this->result .="</select></div>";
				  }
				  
				  
				  // check if form field is Multiple Select dropdown
				  else if($this->formfields[$i]['fieldtype'] == "multiselect")
				  {
					
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";  

				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label><select class='form-control chosen-select' multiple name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' ".$datarequired.">";
				  
				  for($s=0;$s<count($this->formfields[$i]['fielddefaultvalue']);$s++)
				  {
					  
					  if(!empty($this->formfields[$i]['selectedvalue']))
					  {
						  
						  $valuetocheck = explode(",", $this->formfields[$i]['selectedvalue']);
						  
						  for($ck=0;$ck<count($valuetocheck);$ck++)
						  {
							  
							 if($valuetocheck[$ck] == $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']])
							 {
								 
								 $fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
						 
						 $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."' selected>".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>";
								 
								 
							 }
							 
							 else
							 {
								
								$fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
						 
						 $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."' >".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>"; 
								 
							 }
							 
						  }
						  
					
						  
						  
						
						  
					  }
					  else
					  {
				  $fieldvalue1 = (isset($this->formfields[$i]['fieldvaluedesc1'])) ? $this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc1']] : "";
				  $this->result .= "<option value='".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvalue']]."'>".$this->formfields[$i]['fielddefaultvalue'][$s][$this->formfields[$i]['fieldvaluedesc']]." ".$fieldvalue1."</option>";
				  
					  }
				  
				  }
				  
				  $this->result .="</select></div>";
				  }
				  
				  
				  // check if form field is emptydropdown
				  else if($this->formfields[$i]['fieldtype'] == "emptyselect")
				  {
					  
				  $datarequired = !empty($this->formfields[$i]['data-required']) ? "data-required='".$this->formfields[$i]['data-required']."'" : "";
					  
				  $this->result .= "<div class='form-group'>
				  <label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label><select class='form-control' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' ".$datarequired.">";
				  
				  if(isset($this->formfields[$i]['editvalues']) and !empty($this->formfields[$i]['editvalues']))
				  {
					  $this->result .= "<option value='".$this->formfields[$i]['editvalues']."'>".$this->formfields[$i]['editdesc']."</option>";
				  }
				  else
				  {
				    $this->result .= "<option value='".$this->formfields[$i]['fieldvalue']."'>".$this->formfields[$i]['fieldvaluedesc']."</option>";
				  }
				  
				  $this->result .="</select></div>";
				  }
				  
				  // check if form field is checkbox
				  else if($this->formfields[$i]['fieldtype'] == "checkbox")
				  {
				  $this->result .= "<div class='form-group'><label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>";
				  
				  foreach ($this->formfields[$i]['fielddefaultvalue'] as $key => $value)
				  {
					  
				  foreach ($this->formfields[$i]['fieldselected'] as $selectedkey => $selectedvalue)
				  {
					  if($selectedkey == $key)
					  {		
				  $this->result .= "<div class='checkbox'><label><input type='checkbox' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."' checked>".$value."</label></div>";
					  }
					  else
					  {
					  $this->result .= "<div class='checkbox'><label><input type='checkbox' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."'>".$value."</label></div>";	
					  }
				  }
				  
				  }
				  
				  $this->result .="</div>";
				  }
				  
				  // check if form field is radiobox
				  else if($this->formfields[$i]['fieldtype'] == "radio")
				  {
				  $this->result .= "<div class='form-group'><label for='".$this->formfields[$i]['fieldname']."'>".$this->formfields[$i]['fielddesc']."</label>";
				  
				  foreach ($this->formfields[$i]['fielddefaultvalue'] as $key => $value)
				  {
					  
				  foreach ($this->formfields[$i]['fieldselected'] as $selectedkey => $selectedvalue)
				  {
					  if($selectedkey == $key)
					  {		
				  $this->result .= "<div class='radio'><label><input type='radio' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."' checked>".$value."</label></div>";
					  }
					  else
					  {
					  $this->result .= "<div class='radio'><label><input type='radio' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."'>".$value."</label></div>";	
					  }
				  }
				  
				  }
				  
				  
				  
				  $this->result .="</div>";
					  
				  }
				  
				  
				  // check if form field is image
				  else if($this->formfields[$i]['fieldtype'] == "imagethumbnail")
				  {
					  
					  $this->result .= "<div class='row'><div class='col-xs-6 col-md-3'><a href='#' class='thumbnail'><img src='".$this->formfields[$i]['imageurl']."' ></a></div></div>";
					  
				  }
				  
				  
				  
				  
				  } 
				  
				  
				  $this->result .= '<div class="line line-dashed b-b line-lg pull-in"></div>';
				  
				  for($i=0;$i<count($this->formbuttons);$i++)
				  {
				  
				  $this->result .= "<button type='".$this->formbuttons[$i]['buttontype']."' class='".$this->formbuttons[$i]['buttoncss']."'>".$this->formbuttons[$i]['buttonname']."</button>&nbsp;&nbsp;";
				  
				  }
				  
				  $this->result .= "</form>";
				  return $this->result;
		}// end of formgenrator function
		
		
		
		public function LoginGenrateForm(){
				  
				  // add form element in the form genrator first
				  $this->result .= "<form role='form' method='".$this->formtype."' data-validate='parsley'>";
				  
				  // add form fields
				  for($i=0;$i<count($this->formfields);$i++)
				  {
				  
				  // check if form field is text
				  if($this->formfields[$i]['fieldtype'] == "text" || $this->formfields[$i]['fieldtype'] == "email" || $this->formfields[$i]['fieldtype'] == "password")
				  {
					
				  $datatype = !empty($this->formfields[$i]['data-type']) ? "data-type='".$this->formfields[$i]['data-type']."'" : "";
				  
				  $datavalidator = !empty($this->formfields[$i]['validator']) ? $this->formfields[$i]['validator'] : "";
					
				  $this->result .= "<div class='form-group'>
				  <input type='".$this->formfields[$i]['fieldtype']."' class='form-control' id='".$this->formfields[$i]['fieldname']."' name='".$this->formfields[$i]['fieldname']."' placeholder='".$this->formfields[$i]['fieldplaceholder']."' value='".$this->formfields[$i]['fieldvalue']."' ".$datatype." ".$datavalidator." data-required='".$this->formfields[$i]['data-required']."'>
				</div>";
				  }
				  
				  		  
				  // check if form field is dropdown
				  else if($this->formfields[$i]['fieldtype'] == "select")
				  {
				  $this->result .= "<div class='form-group'>
				  <select class='form-control' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."'>";
				  
				  foreach ($this->formfields[$i]['fielddefaultvalue'] as $key => $value)
				  {
					  $this->result .= "<option value='".$key."'>".$value."</option>";
				  }
				  
				  $this->result .="</select></div>";
				  }
				  
				  // check if form field is checkbox
				  else if($this->formfields[$i]['fieldtype'] == "checkbox")
				  {
				  $this->result .= "<div class='form-group'>";
				  
				  foreach ($this->formfields[$i]['fielddefaultvalue'] as $key => $value)
				  {
					  
				  foreach ($this->formfields[$i]['fieldselected'] as $selectedkey => $selectedvalue)
				  {
					  if($selectedkey == $key)
					  {		
				  $this->result .= "<div class='checkbox'><label><input type='checkbox' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."' checked>".$value."</label></div>";
					  }
					  else
					  {
					  $this->result .= "<div class='checkbox'><label><input type='checkbox' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."'>".$value."</label></div>";	
					  }
				  }
				  
				  }
				  
				  $this->result .="</div>";
				  }
				  
				  // check if form field is radiobox
				  else if($this->formfields[$i]['fieldtype'] == "radio")
				  {
				  $this->result .= "<div class='form-group'>";
				  
				  foreach ($this->formfields[$i]['fielddefaultvalue'] as $key => $value)
				  {
					  
				  foreach ($this->formfields[$i]['fieldselected'] as $selectedkey => $selectedvalue)
				  {
					  if($selectedkey == $key)
					  {		
				  $this->result .= "<div class='radio'><label><input type='radio' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."' checked>".$value."</label></div>";
					  }
					  else
					  {
					  $this->result .= "<div class='radio'><label><input type='radio' name='".$this->formfields[$i]['fieldname']."' id='".$this->formfields[$i]['fieldname']."' value='".$key."'>".$value."</label></div>";	
					  }
				  }
				  
				  }
				  
				  
				  
				  $this->result .="</div>";
					  
				  }
				  
				  
				  } 
				  
				  
				  for($i=0;$i<count($this->formbuttons);$i++)
				  {
				  
				  $this->result .= "<button type='".$this->formbuttons[$i]['buttontype']."' class='".$this->formbuttons[$i]['buttoncss']."'>".$this->formbuttons[$i]['buttonname']."</button>";
				  
				  }
				  
				  $this->result .= "</form>";
				  return $this->result;
		}// end of login formgenrator function
	
}
?>
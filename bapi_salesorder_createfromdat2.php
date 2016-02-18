<?
function bapi_salesorder_createfromdat2($p_val) 
{
	$val = explode("~", $p_val);
	
	// normalizing material number, partner number, item number
	$val[10] = str_pad($val[10], 18, "0", STR_PAD_LEFT);
	$val[7] = str_pad($val[7], 10, "0", STR_PAD_LEFT);
	$val[9] = str_pad($val[9], 6, "0", STR_PAD_LEFT);
	
	//Login to SAP R/3
	$login = array (
				"ASHOST"=>"",
				"SYSNR"=>"00",
				"CLIENT"=>"",
				"USER"=>"",
				"PASSWD"=>"",
				"LANG"=>"EN",
				"CODEPAGE"=>"1100");
	$rfc = saprfc_open ($login );
	if (! $rfc ) { echo "RFC connection failed"; exit; }
	//Discover interface for function module BAPI_SALESORDER_CREATEFROMDAT2
	$fce = saprfc_function_discover($rfc,"BAPI_SALESORDER_CREATEFROMDAT2");
	if (! $fce ) { echo "Discovering interface of function module failed"; exit; }
	
	//Set import parameters. 
	saprfc_import ($fce,"ORDER_HEADER_IN", array (
			"DOC_TYPE"=>"$val[0]",
			"SALES_ORG"=>"$val[1]",
			"DISTR_CHAN"=>"$val[2]",
			"DIVISION"=>"$val[3]",
			"SALES_GRP"=>"$val[5]",
			"SALES_OFF"=>"$val[4]",
			"PURCH_NO_C"=>"$val[8]")
		);
	
	//Fill internal tables
	saprfc_table_init ($fce,"EXTENSIONIN");
	saprfc_table_init ($fce,"ORDER_CCARD");
	saprfc_table_init ($fce,"ORDER_CFGS_BLOB");
	saprfc_table_init ($fce,"ORDER_CFGS_INST");
	saprfc_table_init ($fce,"ORDER_CFGS_PART_OF");
	saprfc_table_init ($fce,"ORDER_CFGS_REF");
	saprfc_table_init ($fce,"ORDER_CFGS_REFINST");
	saprfc_table_init ($fce,"ORDER_CFGS_VALUE");
	saprfc_table_init ($fce,"ORDER_CFGS_VK");
	saprfc_table_init ($fce,"ORDER_CONDITIONS_IN");
	saprfc_table_append ($fce,"ORDER_CONDITIONS_IN", array (
			"ITM_NUMBER"=>"$val[9]",
			"COND_TYPE"=>"PR00",
			"COND_VALUE"=>"$val[13]")
		);
	saprfc_table_init ($fce,"ORDER_ITEMS_IN");
	saprfc_table_append ($fce,"ORDER_ITEMS_IN", array (
			"ITM_NUMBER"=>"$val[9]",
			"MATERIAL"=>"$val[10]",
			"ITEM_CATEG"=>"ZTAK")
		);
	saprfc_table_init ($fce,"ORDER_ITEMS_INX");
	saprfc_table_init ($fce,"ORDER_KEYS");
	saprfc_table_init ($fce,"ORDER_PARTNERS");
	saprfc_table_append ($fce,"ORDER_PARTNERS", array (
			"PARTN_ROLE"=>"$val[6]",
			"PARTN_NUMB"=>"$val[7]")
		);
	saprfc_table_init ($fce,"ORDER_SCHEDULES_IN");
	saprfc_table_append ($fce,"ORDER_SCHEDULES_IN", array (
			"ITM_NUMBER"=>"$val[9]",
			"REQ_QTY"=>"$val[11]")
		);
	saprfc_table_init ($fce,"ORDER_SCHEDULES_INX");
	saprfc_table_init ($fce,"ORDER_TEXT");
	saprfc_table_init ($fce,"PARTNERADDRESSES");
	saprfc_table_init ($fce,"RETURN");
	//Do RFC call of function BAPI_SALESORDER_CREATEFROMDAT2
	$rfc_rc = saprfc_call_and_receive ($fce);
	if ($rfc_rc != SAPRFC_OK) { if ($rfc == SAPRFC_EXCEPTION ) echo ("Exception raised: ".saprfc_exception($fce)); else echo (saprfc_error($fce)); exit; }
	//Retrieve export parameters
	$SALESDOCUMENT_EX = saprfc_export ($fce,"SALESDOCUMENT_EX");
	$rows = saprfc_table_rows ($fce,"RETURN");
	for ($i=1;$i<=$rows;$i++)
		$RETURN[] = saprfc_table_read ($fce,"RETURN",$i);
	//Debug info
	//	saprfc_function_debug_info($fce);
	saprfc_function_free($fce);
	?>
	<p>&nbsp;</p>
	<table width="760" align="center" border="0">
		<tr bgcolor="#9FC1EA"> 
		  <td colspan="4">Return messages:</td>
		</tr>
		<tr> 
		  <td width="10%">Type</td>
		  <td width="4%">ID</td>
		  <td width="8%">Number</td>
		  <td width="78%">Message</td>
		</tr>
		<?php
			foreach ($RETURN as $msg) { 
				if ($msg['TYPE'] == "S") $ok = 1; else $ok = 0; ?>
		<tr> 
		  <td width="10%"><?php echo($msg['TYPE']); ?></td>
			<td width="4%"><?php echo($msg['ID']); ?></td>
			<td width="8%"><?php echo($msg['NUMBER']); ?></td>
			<td width="78%"><?php echo($msg['MESSAGE']); ?></td>
		</tr>
		<?php
			} ?>
	</table>
	<?php
	if ($ok == 1) {
		//Discover interface for function module BAPI_TRANSACTION_COMMIT
		$fce = saprfc_function_discover($rfc,"BAPI_TRANSACTION_COMMIT");
		if (! $fce ) { echo "Discovering interface of function module failed"; exit; }
		//Set import parameters.
		saprfc_import ($fce,"WAIT","");
		//Do RFC call of function BAPI_TRANSACTION_COMMIT
		$rfc_rc = saprfc_call_and_receive ($fce);
		if ($rfc_rc != SAPRFC_OK) { if ($rfc == SAPRFC_EXCEPTION ) echo ("Exception raised: ".saprfc_exception($fce)); else echo (saprfc_error($fce)); exit; }
		//Retrieve export parameters
		$RETURN = saprfc_export ($fce,"RETURN");
		saprfc_function_free($fce);
	} else {
		//Discover interface for function module BAPI_TRANSACTION_ROLLBACK
		$fce = saprfc_function_discover($rfc,"BAPI_TRANSACTION_ROLLBACK");
		if (! $fce ) { echo "Discovering interface of function module failed"; exit; }
		//Do RFC call of function BAPI_TRANSACTION_ROLLBACK
		$rfc_rc = saprfc_call_and_receive ($fce);
		if ($rfc_rc != SAPRFC_OK) { if ($rfc == SAPRFC_EXCEPTION ) echo ("Exception raised: ".saprfc_exception($fce)); else echo (saprfc_error($fce)); exit; }
		//Retrieve export parameters
		$RETURN = saprfc_export ($fce,"RETURN");
		saprfc_function_free($fce);
	}

	saprfc_close($rfc);
}
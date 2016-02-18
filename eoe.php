<?php
include ("config.php");
include ("bapi_salesorder_createfromdat2.php");

// set default values
if (! isset($_POST['doc_type'])) $doc_type = set_default('eoe_doc_type'); else $doc_type = $_POST['doc_type'];
if (! isset($_POST['sales_org'])) $sales_org = set_default('eoe_sales_org'); else $sales_org = $_POST['sales_org'];
if (! isset($_POST['distr_chann'])) $distr_chann = set_default('eoe_distr_chann'); else $distr_chann = $_POST['distr_chann'];
if (! isset($_POST['division'])) $division = set_default('eoe_division'); else $division = $_POST['division'];
if (! isset($_POST['sales_off'])) $sales_off = set_default('eoe_sales_off'); else $sales_off = $_POST['sales_off'];
if (! isset($_POST['sales_grp'])) $sales_grp = set_default('eoe_sales_grp'); else $sales_grp = $_POST['sales_grp'];
if (! isset($_POST['partn_role'])) $partn_role = set_default('eoe_partn_role'); else $partn_role = $_POST['partn_role'];// table TPART-PARVW lang. DE
if (! isset($_POST['partn_numb'])) $partn_numb = set_default('eoe_partn_numb'); else $partn_numb = $_POST['partn_numb'];
if (! isset($_POST['sunit'])) $sunit = set_default('eoe_sunit'); else $sunit = $_POST['sunit'];
// reading _POST data
if (! isset($_POST['ponumb'])) ; else $ponumb = $_POST['ponumb'];
if (! isset($_POST['inumb'])) ; else $inumb = $_POST['inumb'];
if (! isset($_POST['matnr'])) $matnr = 1; else $matnr = $_POST['matnr'];
$mat_nr = str_pad($matnr, 18, "0", STR_PAD_LEFT);
if (! isset($_POST['oqty'])) ; else $oqty = $_POST['oqty'];
if (! isset($_POST['rate'])) $rate = 0.01 ; else $rate = $_POST['rate'];

?>
<html>
<head>
<title>Easy Order Entry - SAP R/3</title>
<script language="JavaScript">
<!--
function validateSubmit() {
	// very basic missing data handling
	checkentry=myform.ponumb.value;
	if (checkentry=='') {
		alert('Purchase Order number (PO number) must be specified. Please enter a value.');
		document.myform.ponumb.focus();
		event.returnValue=false;
	}
	checkentry=myform.inumb.value;
	if (checkentry=='') {
		alert('Item number is a mandatory entry. Please try again.');
		document.myform.inumb.focus();
		event.returnValue=false;
	}
	checkentry=myform.matnr.value;
	if (checkentry==1) {
		alert('A Material code must be specified. Please select one.');
		document.myform.matnr.focus();
		event.returnValue=false;
	}
	checkentry=myform.oqty.value;
	if (checkentry=='') {
		alert('Order quantity must be specified. Please try again.');
		document.myform.oqty.focus();
		event.returnValue=false;
	}
}
// -->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">

<table width="760" align="center" border="0">
	<h1><font color="#3366CC">SAPRFC:<br>SD - Easy Order Entry</font></h1>
  <form name="myform" method="post" action="<?php echo($PHP_SELF); ?>" onSubmit="validateSubmit();">
    <tr> 
      <td width="18%" style="font-size:14px;">Order type</td>
      <td width="16%"> 
        <select name="doc_type" id="doc_type" style="WIDTH: 80px; font-size:9px;">
        <?php $vals = draw_sel('eoe_doc_type', $doc_type).'~'; ?>
        </select>
      </td>
      <td width="66%">
      	<input type="submit" name="Submit" value="create order">
      </td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <hr>
      </td>
    </tr>
    <tr> 
      <td colspan="3" bgcolor="#999999"><b><font color="#FFFFFF">Header data</font></b></td>
    </tr>
    <tr> 
      <td width="18%">Sales organization</td>
      <td width="16%"> 
        <select name="sales_org" id="sales_org" style="WIDTH: 60px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_sales_org', $sales_org).'~'; ?>
        </select>
      </td>
      <td width="66%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="18%">Distribution channel</td>
      <td width="16%"> 
        <select name="distr_chann" id="distr_chann" style="WIDTH: 46px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_distr_chann', $distr_chann).'~'; ?>
        </select>
      </td>
      <td width="66%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="18%">Division</td>
      <td width="16%"> 
        <select name="division" id="division" style="WIDTH: 46px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_division', $division).'~'; ?>
        </select>
      </td>
      <td width="66%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="18%">Sales office</td>
      <td width="16%"> 
        <select name="sales_off" id="sales_off" style="WIDTH: 56px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_sales_off', $sales_off).'~'; ?>
        </select>
      </td>
      <td width="66%">&nbsp;</td>
    </tr>
    <tr> 
      <td width="18%" height="24">Sales group</td>
      <td width="16%" height="24"> 
        <select name="sales_grp" id="sales_grp" style="WIDTH: 56px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_sales_grp', $sales_grp).'~'; ?>
        </select>
      </td>
      <td width="66%"> &nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <hr>
      </td>
    </tr>
    <tr> 
      <td colspan="3" bgcolor="#999999"><b><font color="#FFFFFF">Partner data</font></b></td>
    </tr>
    <tr>
      <td width="18%">Partner function</td>
      <td width="16%"> 
        <select name="partn_role" id="partn_role" style="WIDTH: 46px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_partn_role', $partn_role).'~'; ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td width="18%">Partner number</td>
      <td width="16%"> 
        <select name="partn_numb" id="partn_numb" style="WIDTH: 80px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_partn_numb', $partn_numb).'~'; ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td width="18%">PO number</td>
      <td>
        <input type="text" name="ponumb" style="WIDTH: 120px; HEIGHT: 20px; font-size:9px;" value="<? echo $ponumb; ?>">
        <?php $vals .= $ponumb.'~'; ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <hr>
      </td>
    </tr>
    <tr> 
      <td colspan="3" bgcolor="#999999"><b><font color="#FFFFFF">Item data</font></b></td>
    </tr>
    <tr> 
      <td>Item number</td>
      <td>
      	<input type="text" name="inumb" style="WIDTH: 40px; HEIGHT: 20px; font-size:9px;" value="<? echo $inumb; ?>">
      	<?php $vals .= $inumb.'~'; ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Material</td>
      <td>
        <select name="matnr" id="matnr" style="WIDTH: 80px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_matnr', $matnr).'~'; ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Order quantity</td>
      <td>
      	<input type="text" name="oqty" style="WIDTH: 60px; HEIGHT: 20px; font-size:9px;" value="<? echo $oqty; ?>">
      	<?php $vals .= $oqty.'~'; ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Unit of measure</td>
      <td>
      	<select name="sunit" id="sunit" style="WIDTH: 45px; font-size:9px;">
        <?php $vals .= draw_sel('eoe_sunit', $sunit).'~'; ?>
        </select>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Rate</td>
      <td>
      	<input type="text" name="rate" style="WIDTH: 55px; HEIGHT: 20px; font-size:9px;" value="<? echo $rate; ?>">
      	<?php $vals .= $rate.'~'; ?>
      </td>
      <td>&nbsp;</td>
    </tr>
  </form>
</table>
<?php
//calling function
if (isset($_POST['Submit'])) bapi_salesorder_createfromdat2($vals); ?>
</body>
</html>

<?php
function draw_sel($table, $idx)
{
	$qry = "SELECT * FROM $table";
	$result = mysql_query($qry) or die("Problem with the query: ".$qry.'<br>'.mysql_error());
	while ($row = mysql_fetch_array($result)) {
		if (intval($row['eoe_idx']) == $idx) {
			$txt = substr($table, 4);
			$v = $row[$table];?>
			<option selected value=" <?php echo($row['eoe_idx']); ?> "> <?php 
		} else { ?>
			<option value=" <?php echo($row['eoe_idx']); ?> "> <?php	
		}
		echo($row[$table]); ?></option> <?php
	}
	return $v;
}

function set_default($table)
{
	$qry = "SELECT eoe_idx FROM $table WHERE eoe_default = 'x'";
	$result = mysql_query($qry) or die("Problem with the query: ".$qry.'<br>'.mysql_error());
	return (mysql_result ($result, 0));
}
?>

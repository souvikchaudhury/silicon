<?php
	if( isset($_COOKIE['inventoryartworkimgurl']) ) {
		ob_end_clean();
		$imgUrl = $_COOKIE['inventoryartworkimgurl'];
		$imgTitle = $_COOKIE['inventoryartworkimgtitle'];
		$img = explode('/', $imgUrl);
		$relativeimgpath = dirname(__FILE__).'/uploads/'.end($img);

		$content = "<page>";
		$content .= "<img src='$relativeimgpath' alt='$imgTitle' />";
		$content .= "</page>";
		unset($_COOKIE['inventoryartworkimgurl'], $_COOKIE['inventoryartworkimgtitle']);
		require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');	
		$html2pdf = new HTML2PDF('P','A4','fr');
    	$html2pdf->WriteHTML($content);
		$html2pdf->Output('inventoryimage.pdf', 'D');
	}
?>
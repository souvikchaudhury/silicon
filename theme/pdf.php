<?php
	if( isset($_COOKIE['inventoryartworkimgurl']) ) {
		ob_end_clean();
		$imgUrl = $_COOKIE['inventoryartworkimgurl'];
		$imgTitle = $_COOKIE['inventoryartworkimgtitle'];

		$img = explode('/', $imgUrl);
		$str = str_replace('\\', '/', dirname(__FILE__));
		$relativeimgpath = $str.'/upload/'.end($img);
		
		// $imgarr = explode('<*>',$imgUrl);

		$content = "<page>";
		// $content .= $imgUrl;
		/*foreach($imgarr as $value){
			$img = explode('/', $value);
			$str = str_replace('\\', '/', dirname(__FILE__));
			$relativeimgpath = $str.'/upload/'.end($img);
			// $content .=$relativeimgpath.'\n';
			$content .= "<img src='$relativeimgpath' alt='$imgTitle' height='200px' width='200px'/>";
		}*/
		$content .= "<img src='$relativeimgpath' alt='$imgTitle' height='200px' width='200px'/>";
		// $content .= "<img src='$relativeimgpath' alt='$imgTitle' />";
		$content .= "</page>";
		unset($_COOKIE['inventoryartworkimgurl'], $_COOKIE['inventoryartworkimgtitle']);
		require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');	
		$html2pdf = new HTML2PDF('P','A4','fr');
    	$html2pdf->WriteHTML($content);
		$html2pdf->Output('inventoryimage.pdf', 'D');
	}
?>